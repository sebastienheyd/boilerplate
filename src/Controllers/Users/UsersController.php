<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Role;
use App\Models\ThirdParty;
use App\Models\User;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Mail;
use Auth;
use URL;
use DB;
use Yajra\Datatables\Datatables;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('ability:admin,users_crud', ['except' => ['firstLogin', 'firstLoginPost', 'avatar', 'avatarDelete', 'avatarPost']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.list');
    }

    /**
     * Liste des utilisateurs
     *
     * @return mixed
     */
    public function datatable()
    {
        return Datatables::of(User::select('*'))->editColumn('created_at', function ($user) {
            return ucwords($user->created_at->formatLocalized('%A %d %B %Y'));
        })->editColumn('avatar', function ($user) {
            return sprintf('<img src="%s" class="avatar" />', $user->getAvatar());
        })->editColumn('roles', function ($user) {
            return $user->getRolesList();
        })->editColumn('actions', function ($user) {
            $currentUser = Auth::user();

            // Les admins peuvent tout éditer
            if ($currentUser->hasRole('admin')) {
                $b = '<a href="' . URL::route('utilisateurs.edit', $user->id) . '" class="btn btn-primary btn-sm mrs"><i class="fa fa-pencil"></i></a>';
                if ($user->id !== $currentUser->id) {
                    $b .= '<a href="' . URL::route('utilisateurs.destroy', $user->id) . '" class="btn btn-danger btn-sm destroy"><i class="fa fa-trash"></i></a>';
                }
                return $b;
            }

            // L'utilisateur est l'utilisateur courant
            if ($user->id === $currentUser->id) {
                return '<a href="' . URL::route('utilisateurs.edit', $user->id) . '" class="btn btn-primary btn-sm mrs"><i class="fa fa-pencil"></i></a>';
            }

            // Si l'utilisateur
            if (!$user->hasRole('admin') && !$user->hasRole('gestionnaire')) {
                $b = '<a href="' . URL::route('utilisateurs.edit', $user->id) . '" class="btn btn-primary btn-sm mrs"><i class="fa fa-pencil"></i></a>';
                $b .= '<a href="' . URL::route('utilisateurs.destroy', $user->id) . '" class="btn btn-danger btn-sm destroy"><i class="fa fa-trash"></i></a>';
            }

            return '';
        })->make(true);
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

        if (is_null($user)) {
            abort(404);
        }

        return view('users.firstlogin', compact('user', 'token'));
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
        $user->save();

        Auth::attempt(['email' => $user->email, 'password' => $request->input('password'), 'status' => 1]);

        return redirect('/accueil');
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
            $roles = Role::whereNotIn('name', ['admin', 'gestionnaire'])->get();
        } else {
            $roles = Role::all();
        }
        return view('users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['last_name' => 'required', 'first_name' => 'required', 'email' => 'required|email|unique:users,email']);

        // Récupération des données postées
        $input = $request->all();

        // Génération du mot de passe et token
        $password = str_random(8);
        $input['password'] = $password;
        $remember_token = str_random(32);
        $input['remember_token'] = $remember_token;

        // Création de l'utilisateur
        $user = User::create($input);

        // On attache le(s) rôle(s)
        if ($roles = $request->input('roles', false)) {
            foreach ($roles as $id => $val) {
                $user->roles()->attach($id);
            }
        }

        // On attache le(s) tiers
        if ($thirdparties = $request->input('thirdparties', false)) {
            foreach ($thirdparties as $id) {
                $user->thirdparties()->attach($id);
            }
        }

        //On attache les centres de formation
        if (!empty($request->input('training_centers'))) {
            foreach ($request->input('training_centers') as $id) {
                $user->training_centers()->attach($id);
            }
        }

        // Envoi du mail
        Email::send('new_user', function ($email) use ($user, $remember_token) {
            $email->to = $user->email;
            $email->first_name = $user->first_name;
            $email->site_url = URL::to('/');
            $email->link = URL::route('first.login', $remember_token);
        });

        return redirect()->route('utilisateurs.edit', $user)->with('growl', "L'utilisateur a été correctement ajouté");
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

        // Filtres des rôles si pas admin
        if (!Auth::user()->hasRole('admin')) {
            $roles = Role::whereNotIn('name', ['admin', 'gestionnaire'])->get();
        } else {
            $roles = Role::all();
        }

        return view('users.edit', compact('user', 'roles'));
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
            'password' => 'string|min:8',
            'password_confirm' => 'required_with:password|same:password',
            'email' => 'required|email|unique:users,email,' . $id
        ], [], [
            'password_confirm' => 'Confirmation'
        ]);

        $user = User::findOrFail($id);
        $data = $request->all();

        if($data['password'] !== '') {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->fill($data)->push();
        
        // Mise à jour des rôles
        $user->roles()->sync(array_keys($request->input('roles', [])));

        // Mise à jour des tiers
        $user->thirdparties()->sync($request->input('thirdparties', []));

        // Mise à jour des centres
        $user->training_centers()->sync($request->input('training_centers', []));

        return redirect(route('utilisateurs.edit', $user))->with('growl', "L'utilisateur a été correctement modifié");
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

    /**
     * Génère la clé de l'api
     * @param Request $request
     */
    public function generatekey(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        $user->api_key = Str::random();
        $user->update();
        return view('users.apikey', compact('user'));
    }

    /**
     * Supprime la clé de l'api
     * @param Request $request
     */
    public function deletekey(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        $user->api_key = null;
        $user->update();
        return view('users.newapikey', compact('user'));
    }
}
