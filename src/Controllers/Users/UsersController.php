<?php

namespace Sebastienheyd\Boilerplate\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Datatables;
use Sebastienheyd\Boilerplate\Models\Role;
use Sebastienheyd\Boilerplate\Models\User;
use Auth;
use URL;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('ability:admin,users_crud', ['except' => ['avatar', 'avatarDelete', 'avatarPost', 'firstLogin', 'firstLoginPost']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::users.list');
    }

    /**
     * Liste des utilisateurs
     *
     * @return mixed
     */
    public function datatable()
    {
        return Datatables::of(User::select('*'))
          ->rawColumns(['actions'])
          ->editColumn('created_at', function ($user) {
            return ucwords($user->created_at->format(__('boilerplate::date.lFdY')));
        })->editColumn('roles', function ($user) {
            return $user->getRolesList();
        })->editColumn('actions', function ($user) {
            $currentUser = Auth::user();

            // Les admins peuvent tout éditer
            if ($currentUser->hasRole('admin')) {
                $b = '<a href="' . URL::route('users.edit', $user->id) . '" class="btn btn-primary btn-sm mrs"><i class="fa fa-pencil"></i></a>';
                if ($user->id !== $currentUser->id) {
                    $b .= '<a href="' . URL::route('users.destroy', $user->id) . '" class="btn btn-danger btn-sm destroy"><i class="fa fa-trash"></i></a>';
                }
                return $b;
            }

            // L'utilisateur est l'utilisateur courant
            if ($user->id === $currentUser->id) {
                return '<a href="' . URL::route('users.edit', $user) . '" class="btn btn-primary btn-sm mrs"><i class="fa fa-pencil"></i></a>';
            }

            // Si l'utilisateur
            if (!$user->hasRole('admin')) {
                $b = '<a href="' . URL::route('users.edit', $user->id) . '" class="btn btn-primary btn-sm mrs"><i class="fa fa-pencil"></i></a>';
                $b .= '<a href="' . URL::route('users.destroy', $user->id) . '" class="btn btn-danger btn-sm destroy"><i class="fa fa-trash"></i></a>';
            }

            return '';
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
    }

    /**
     * Affichage du formulaire de création du mot de passe
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
     * Traitement de la création du mot de passe
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
