<?php

namespace Sebastienheyd\Boilerplate\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Datatables;
use Sebastienheyd\Boilerplate\Models\Role;
use Sebastienheyd\Boilerplate\Models\User;
use Auth;
use URL;

class UsersController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Users Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the users management.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('ability:admin,users_crud', [
            'except' => [
                'firstLogin',
                'firstLoginPost',
                'avatar',
                'avatarDelete',
                'avatarPost'
            ]
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
     * To display dynamic table by datatable
     *
     * @return mixed
     */
    public function datatable()
    {
        return Datatables::of(User::select('*'))
          ->rawColumns(['actions', 'status'])
          ->editColumn('created_at', function ($user) {
            return $user->created_at->format(__('boilerplate::date.YmdHis'));
        })->editColumn('last_login', function ($user) {
            return $user->getLastLogin(__('boilerplate::date.YmdHis'), '-');
        })->editColumn('status', function ($user) {
            if($user->active == 1) return '<span class="label label-success">Activé</span>';
            return '<span class="label label-danger">Désactivé</span>';
        })->editColumn('roles', function ($user) {
            return $user->getRolesList();
        })->editColumn('actions', function ($user) {
            $currentUser = Auth::user();

            // Admin can edit and delete anyone...
            if ($currentUser->hasRole('admin')) {
                $b = '<a href="' . URL::route('users.edit', $user->id) . '" class="btn btn-primary btn-sm mrs"><i class="fa fa-pencil"></i></a>';

                // ...except delete himself
                if ($user->id !== $currentUser->id) {
                    $b .= '<a href="' . URL::route('users.destroy', $user->id) . '" class="btn btn-danger btn-sm destroy"><i class="fa fa-trash"></i></a>';
                }
                return $b;
            }

            // The user is the current user, you can't delete yourself
            if ($user->id === $currentUser->id) {
                return '<a href="' . URL::route('users.edit', $user) . '" class="btn btn-primary btn-sm mrs"><i class="fa fa-pencil"></i></a>';
            }

            $b = '<a href="' . URL::route('users.edit', $user->id) . '" class="btn btn-primary btn-sm mrs"><i class="fa fa-pencil"></i></a>';

            // Current user is not admin, only admin can delete another admin
            if(!$user->hasRole('admin')) {
                $b .= '<a href="' . URL::route('users.destroy', $user->id) . '" class="btn btn-danger btn-sm destroy"><i class="fa fa-trash"></i></a>';
            }

            return $b;

        })->make(true);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Filtres des rôles si pas admin
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'last_name' => 'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email'
        ]);

        $input = $request->all();
        $input['password'] = bcrypt(str_random(8));
        $input['remember_token'] = str_random(32);

        $user = User::create($input);
        $user->roles()->sync(array_keys($request->input('roles')));

        $user->sendNewUserNotification($input['remember_token'], Auth::user());

        return redirect()->route('users.edit', $user)->with('growl', "L'utilisateur a été correctement ajouté");
    }

    /**
     * Display the specified user.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort('404');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int $id
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'last_name' => 'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id
        ]);

        $user = User::findOrFail($id);

        $user->update($request->all());
        
        // Mise à jour des rôles
        $user->roles()->sync(array_keys($request->input('roles', [])));

        return redirect(route('users.edit', $user))->with('growl', "L'utilisateur a été correctement modifié");
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
    }

    /**
     * Show the form to set a new password on the first login
     *
     * @param $token
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function firstLogin($token, Request $request)
    {
        $user = User::where(['remember_token' => $token])->first();
        if (is_null($user)) abort(404);
        return view('boilerplate::auth.firstlogin', compact('user', 'token'));
    }

    /**
     * Store a newly created password in storage after the first login.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function firstLoginPost(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);

        $user = User::where(['remember_token' => $request->input('token')])->first();

        $user->password = bcrypt($request->input('password'));
        $user->remember_token = str_random(32);
        $user->last_login = Carbon::now()->toDateTimeString();
        $user->save();

        Auth::attempt(['email' => $user->email, 'password' => $request->input('password'), 'active' => 1]);

        return redirect()->route('boilerplate.home')->with('growl', "Votre mot de passe a bien été enregistré.");
    }

    public function avatar()
    {
        return view('users.avatar');
    }

    public function avatarPost(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|mimes:jpeg,png|max:10000'
        ]);

        $avatar = $request->file('avatar');

        if ($file = $avatar->isValid()) {
            $destinationPath = public_path('images/avatars');
            $extension = $avatar->getClientOriginalExtension();
            $fileName = str_pad(Auth::user()->id, 6, '0', STR_PAD_LEFT) . '_tmp.' . $extension;
            $avatar->move($destinationPath, $fileName);

            Image::make($destinationPath . DIRECTORY_SEPARATOR . $fileName)
                ->fit(100, 100)
                ->save($destinationPath . DIRECTORY_SEPARATOR . str_pad(Auth::user()->id, 6, '0', STR_PAD_LEFT) . '.jpg');

            unlink($destinationPath . DIRECTORY_SEPARATOR . $fileName);

            return redirect()->route('users.avatar')->with('growl', "La photo a été téléchargée");
        } else {
            return redirect()->route('users.avatar')->with('growl', "Une erreur s'est produite !");
        }
    }

    public function avatarDelete()
    {
        unlink(public_path('images/avatars/' . str_pad(Auth::user()->id, 6, '0', STR_PAD_LEFT) . '.jpg'));
        return redirect()->route('users.avatar')->with('growl', "La photo a été supprimée");
    }

}
