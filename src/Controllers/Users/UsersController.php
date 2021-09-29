<?php

namespace Sebastienheyd\Boilerplate\Controllers\Users;

use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;
use Sebastienheyd\Boilerplate\Models\Role;
use Sebastienheyd\Boilerplate\Models\User;
use Sebastienheyd\Boilerplate\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('ability:admin,users_crud', [
            'except' => [
                'firstLogin',
                'firstLoginPost',
                'profile',
                'profilePost',
                'getAvatarUrl',
                'getAvatarFromGravatar',
                'avatarDelete',
                'avatarUpload',
                'keepAlive',
            ],
        ]);
    }

    /**
     * Display a listing of users.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('boilerplate::users.list', ['roles' => Role::all()]);
    }

    /**
     * To display dynamic table by datatable.
     *
     * @param  Request  $request
     * @return mixed
     *
     * @throws Exception
     */
    public function datatable(Request $request)
    {
        $users = User::with('roles');

        if ($request->input('columns.6.search.value') !== null) {
            $users->whereRoleIs($request->input('columns.6.search.value'));
        }

        return Datatables::eloquent($users)
            ->rawColumns(['actions', 'status', 'avatar', 'roles'])
            ->editColumn('avatar', function ($user) {
                return  '<img src="'.$user->avatar_url.'" class="img-circle" width="32" height="32" />';
            })->editColumn('status', function ($user) {
                if ($user->active == 1) {
                    return '<span class="badge badge-pill badge-success">'.__('boilerplate::users.active').'</span>';
                }

                return '<span class="badge badge-pill badge-danger">'.__('boilerplate::users.inactive').'</span>';
            })->editColumn('roles', function ($user) {
                return $user->getRolesList();
            })->editColumn('actions', function ($user) {
                $currentUser = Auth::user();

                // Admin can edit and delete anyone...
                if ($currentUser->hasRole('admin')) {
                    $b = $this->button(route('boilerplate.users.edit', $user->id), 'primary mr-1', 'pencil-alt');

                    // ...except delete himself
                    if ($user->id !== $currentUser->id) {
                        $b .= $this->button(route('boilerplate.users.destroy', $user->id), 'danger destroy', 'trash');
                    }

                    return $b;
                }

                // The user is the current user, you can't delete yourself
                if ($user->id === $currentUser->id) {
                    return $this->button(route('boilerplate.users.edit', $user->id), 'primary mr-1', 'pencil');
                }

                $b = $this->button(route('boilerplate.users.edit', $user->id), 'primary mr1', 'pencil');

                // Current user is not admin, only admin can delete another admin
                if (! $user->hasRole('admin')) {
                    $b .= $this->button(route('boilerplate.users.destroy', $user->id), 'danger destroy', 'trash');
                }

                return $b;
            })->make(true);
    }

    /**
     * Get html button for datatable.
     *
     * @param  string  $route
     * @param  string  $class
     * @param  string  $icon
     * @return string
     */
    protected function button(string $route, string $class, string $icon): string
    {
        $str = '<a href="%s" class="btn btn-sm btn-%s"><i class="fa fa-fw fa-%s"></i></a>';

        return sprintf($str, $route, $class, $icon);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('boilerplate::users.create', [
            'roles' => Auth::user()->hasRole('admin') ? Role::all() : Role::whereNotIn('name', ['admin'])->get(),
        ]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'last_name'  => 'required',
            'first_name' => 'required',
            'email'      => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
        ]);

        $input = $request->all();
        $input['password'] = bcrypt(Str::random(8));
        $input['remember_token'] = Str::random(32);
        $input['deleted_at'] = null;

        $user = User::withTrashed()->updateOrCreate(['email' => $input['email']], $input);
        $user->restore();
        $user->roles()->sync(array_keys($request->input('roles', [])));

        $user->sendNewUserNotification($input['remember_token']);

        return redirect()->route('boilerplate.users.edit', $user)
            ->with('growl', [__('boilerplate::users.successadd'), 'success']);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  User  $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        return view('boilerplate::users.edit', [
            'user' => $user,
            'roles' => Auth::user()->hasRole('admin') ? Role::all() : Role::whereNotIn('name', ['admin'])->get(),
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  User  $user
     * @param  Request  $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function update(User $user, Request $request): RedirectResponse
    {
        $this->validate($request, [
            'last_name'  => 'required',
            'first_name' => 'required',
            'email'      => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update($request->all());

        $user->roles()->sync(array_keys($request->input('roles', [])));

        return redirect()->route('boilerplate.users.edit', $user)
                         ->with('growl', [__('boilerplate::users.successmod'), 'success']);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        return response()->json(['success' => $user->delete() ?? false]);
    }

    /**
     * Show the form to set a new password on the first login.
     *
     * @param $token
     * @return Application|Factory|View
     */
    public function firstLogin($token)
    {
        $user = User::where(['remember_token' => $token])->firstOrFail();

        return view('boilerplate::auth.firstlogin', compact('user', 'token'));
    }

    /**
     * Store a newly created password in storage after the first login.
     *
     * @param  Request  $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function firstLoginPost(Request $request)
    {
        $this->validate($request, [
            'token'                 => 'required',
            'password'              => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = User::where(['remember_token' => $request->input('token')])->first();

        $user->password = bcrypt($request->input('password'));
        $user->remember_token = Str::random(32);
        $user->last_login = Carbon::now()->toDateTimeString();
        $user->save();

        Auth::attempt(['email' => $user->email, 'password' => $request->input('password'), 'active' => 1]);

        return redirect()->route(config('boilerplate.app.redirectTo', 'boilerplate.dashboard'))
                         ->with('growl', [__('boilerplate::users.newpassword'), 'success']);
    }

    /**
     * Show user profile page.
     *
     * @return Application|Factory|View
     */
    public function profile()
    {
        return view('boilerplate::users.profile', ['user' => Auth::user()]);
    }

    /**
     * Post user profile.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function profilePost(Request $request)
    {
        $this->validate($request, [
            'avatar'                => 'mimes:jpeg,png|max:10000',
            'last_name'             => 'required',
            'first_name'            => 'required',
            'password'              => ['nullable', new Password()],
            'password_confirmation' => 'same:password',
        ]);

        $user = Auth::user();

        $input = $request->all();

        if ($input['password'] !== null) {
            $input['password'] = bcrypt($input['password']);
            $input['remember_token'] = Str::random(32);
        } else {
            unset($input['password']);
        }

        $user->update($input);

        return redirect()->route('boilerplate.user.profile')
                         ->with('growl', [__('boilerplate::users.profile.successupdate'), 'success']);
    }

    /**
     * Get profile picture url.
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return Auth::user()->avatar_url;
    }

    /**
     * Delete profile picture.
     *
     * @return JsonResponse
     */
    public function avatarDelete()
    {
        return response()->json(['success' => Auth::user()->deleteAvatar()]);
    }

    /**
     * Avatar upload post.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function avatarUpload(Request $request)
    {
        $user = Auth::user();
        $avatar = $request->file('avatar');

        try {
            if ($avatar && $avatar->isValid()) {
                $destinationPath = dirname($user->avatar_path);
                if (! is_dir($destinationPath)) {
                    mkdir($destinationPath, 0766, true);
                }
                $extension = $avatar->getClientOriginalExtension();
                $fileName = md5($user->id.$user->email).'_tmp.'.$extension;
                $avatar->move($destinationPath, $fileName);

                Image::make($destinationPath.DIRECTORY_SEPARATOR.$fileName)
                    ->fit(170, 170)
                    ->save($user->avatar_path);

                unlink($destinationPath.DIRECTORY_SEPARATOR.$fileName);

                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * Get avatar from Gravatar.com.
     *
     * @return JsonResponse
     */
    public function getAvatarFromGravatar()
    {
        return response()->json(['success' => Auth::user()->getAvatarFromGravatar()]);
    }

    /**
     * Session keep-alive.
     *
     * @param  Request  $request
     */
    public function keepAlive(Request $request)
    {
        session()->setId($request->post('id'));
        session()->start();
    }

    /**
     * Store setting for the current user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function storeSetting(Request $request)
    {
        if (! $request->isXmlHttpRequest()) {
            abort(404);
        }

        return response()->json(['success' => setting([$request->post('name') => $request->post('value')])]);
    }
}
