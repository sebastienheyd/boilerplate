<?php

namespace Sebastienheyd\Boilerplate\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Sebastienheyd\Boilerplate\Rules\Password;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Is registering the first user ?
     *
     * @var bool
     */
    protected $firstUser;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $userModel = config('auth.providers.users.model');
        $this->firstUser = $userModel::whereRoleIs('admin')->count() === 0;
    }

    /**
     * Return route where to redirect after login success.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return route(config('boilerplate.app.redirectTo', 'boilerplate.dashboard'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'last_name'  => 'required|max:255',
            'first_name' => 'required|max:255',
            'email'      => 'required|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'password'   => ['required', 'confirmed', new Password()],
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return Application|Factory|View
     */
    public function showRegistrationForm()
    {
        if (! $this->firstUser && ! config('boilerplate.auth.register')) {
            abort('404');
        }

        return view('boilerplate::auth.register', ['firstUser' => $this->firstUser]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return mixed
     */
    protected function create(array $data)
    {
        if (! $this->firstUser && ! config('boilerplate.auth.register')) {
            abort('404');
        }

        $userModel = config('auth.providers.users.model');
        $roleModel = config('laratrust.models.role');

        $user = $userModel::withTrashed()->updateOrCreate(['email' => $data['email']], [
            'active'     => true,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => bcrypt($data['password']),
            'last_login' => Carbon::now()->toDateTimeString(),
        ]);

        if ($this->firstUser) {
            $admin = $roleModel::whereName('admin')->first();
            $user->attachRole($admin);
        } else {
            $user->restore();
            $role = $roleModel::whereName(config('boilerplate.auth.register_role'))->first();
            $user->roles()->sync([$role->id]);
        }

        return $user;
    }
}
