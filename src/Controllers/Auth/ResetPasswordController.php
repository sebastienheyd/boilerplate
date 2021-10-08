<?php

namespace Sebastienheyd\Boilerplate\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Sebastienheyd\Boilerplate\Rules\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->redirectTo = route(config('boilerplate.app.redirectTo', 'boilerplate.dashboard'));
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  Request  $request
     * @param  string|null  $token
     * @return Application|Factory|View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('boilerplate::auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email ?? '',
        ]);
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', new Password()],
        ];
    }
}
