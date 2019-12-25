<?php

namespace Sebastienheyd\Boilerplate\Controllers\Users;

use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;
use Sebastienheyd\Boilerplate\Models\Role;
use Sebastienheyd\Boilerplate\Models\User;
use Yajra\DataTables\DataTables;

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
                'avatar',
                'avatarDelete',
                'avatarPost',
                'profile',
                'profilePost',
            ],
        ]);
    }

    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::users.list');
    }

    /**
     * To display dynamic table by datatable.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function datatable()
    {
        return Datatables::of(User::select('*'))
            ->rawColumns(['actions', 'status'])
            ->editColumn('created_at', function ($user) {
                return $user->created_at->isoFormat(__('boilerplate::date.YmdHis'));
            })->editColumn('last_login', function ($user) {
                return $user->getLastLogin(__('boilerplate::date.YmdHis'), '-');
            })->editColumn('status', function ($user) {
                if ($user->active == 1) {
                    return '<span class="label label-success">'.__('boilerplate::users.active').'</span>';
                }

                return '<span class="label label-danger">'.__('boilerplate::users.inactive').'</span>';
            })->editColumn('roles', function ($user) {
                return $user->getRolesList();
            })->editColumn('actions', function ($user) {
                $currentUser = Auth::user();

                // Admin can edit and delete anyone...
                if ($currentUser->hasRole('admin')) {
                    $b = $this->button(route('boilerplate.users.edit', $user->id), 'primary mrs', 'pencil');

                    // ...except delete himself
                    if ($user->id !== $currentUser->id) {
                        $b .= $this->button(route('boilerplate.users.destroy', $user->id), 'danger destroy', 'trash');
                    }

                    return $b;
                }

                // The user is the current user, you can't delete yourself
                if ($user->id === $currentUser->id) {
                    return $this->button(route('boilerplate.users.edit', $user->id), 'primary mrs', 'pencil');
                }

                $b = $this->button(route('boilerplate.users.edit', $user->id), 'primary mrs', 'pencil');

                // Current user is not admin, only admin can delete another admin
                if (!$user->hasRole('admin')) {
                    $b .= $this->button(route('boilerplate.users.destroy', $user->id), 'danger destroy', 'trash');
                }

                return $b;
            })->make(true);
    }

    /**
     * Get html button for datatable.
     *
     * @param string $route
     * @param string $class
     * @param string $icon
     *
     * @return string
     */
    private function button(string $route, string $class, string $icon): string
    {
        return sprintf('<a href="%s" class="btn btn-sm btn-%s"><i class="fa fa-%s"></i></a>', $route, $class, $icon);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Filter roles if not admin
        if (!Auth::user()->hasRole('admin')) {
            $roles = Role::whereNotIn('name', ['admin'])->get();
        } else {
            $roles = Role::all();
        }

        return view('boilerplate::users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
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

        $user->sendNewUserNotification($input['remember_token'], Auth::user());

        return redirect()->route('boilerplate.users.edit', $user)
            ->with('growl', [__('boilerplate::users.successadd'), 'success']);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (!Auth::user()->hasRole('admin')) {
            $roles = Role::whereNotIn('name', ['admin'])->get();
        } else {
            $roles = Role::all();
        }

        return view('boilerplate::users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param Request $request
     * @param $id
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'last_name'  => 'required',
            'first_name' => 'required',
            'email'      => 'required|email|unique:users,email,'.$id,
        ]);

        $user = User::findOrFail($id);

        $user->update($request->all());

        $user->roles()->sync(array_keys($request->input('roles', [])));

        return redirect()->route('boilerplate.users.edit', $user)
                         ->with('growl', [__('boilerplate::users.successmod'), 'success']);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
    }

    /**
     * Show the form to set a new password on the first login.
     *
     * @param $token
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function firstLogin($token, Request $request)
    {
        $user = User::where(['remember_token' => $token])->firstOrFail();

        return view('boilerplate::auth.firstlogin', compact('user', 'token'));
    }

    /**
     * Store a newly created password in storage after the first login.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
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

    public function profile()
    {
        return view('boilerplate::users.profile', ['user' => Auth::user()]);
    }

    public function profilePost(Request $request)
    {
        $this->validate($request, [
            'avatar'                => 'mimes:jpeg,png|max:10000',
            'last_name'             => 'required',
            'first_name'            => 'required',
            'password_confirmation' => 'same:password',
        ]);

        $avatar = $request->file('avatar');
        $user = Auth::user();

        if ($avatar && $file = $avatar->isValid()) {
            $destinationPath = dirname($user->avatar_path);
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0766, true);
            }
            $extension = $avatar->getClientOriginalExtension();
            $fileName = md5($user->id.$user->email).'_tmp.'.$extension;
            $avatar->move($destinationPath, $fileName);

            Image::make($destinationPath.DIRECTORY_SEPARATOR.$fileName)
                ->fit(100, 100)
                ->save($user->avatar_path);

            unlink($destinationPath.DIRECTORY_SEPARATOR.$fileName);
        }

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

    public function avatarDelete()
    {
        $user = Auth::user();
        if (is_file($user->avatar_path)) {
            unlink($user->avatar_path);
        }
    }
}
