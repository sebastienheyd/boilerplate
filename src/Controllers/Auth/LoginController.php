<?php

namespace Sebastienheyd\Boilerplate\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController
{
    use AuthenticatesUsers, ValidatesRequests;

    /**
     * Where to redirect after login / register.
     *
     * @return string
     */
    public function redirectTo()
    {
        return route(config('boilerplate.app.redirectTo', 'boilerplate.dashboard'));
    }

    /**
     * Show the application's login form.
     *
     * @return View|Redirector
     */
    public function showLoginForm(Request $request)
    {
        $userModel = config('auth.providers.users.model');

        if ($userModel::whereHasRole('admin')->count() === 0) {
            return redirect(route('boilerplate.register'));
        }

        return view('boilerplate::auth.login', [
            'expired'  => $request->get('expired', false),
            'redirect' => $request->get('path', false),
        ]);
    }

    /**
     * Validate the user login request.
     *
     * @param  Request  $request
     *
     * @throws ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|exists:users,'.$this->username().',active,1',
            'password'        => 'required',
        ], [
            $this->username().'.exists' => __('auth.failed'),
        ]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  Request  $request
     * @return RedirectResponse|JsonResponse|bool
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($this->authenticated($request, $this->guard()->user())) {
            $this->guard()->user()->update(['last_login' => Carbon::now()->toDateTimeString()]);

            $path = $request->post('redirect');

            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect()->intended($path ?: $this->redirectPath());
        }
    }

    /**
     * The user has been authenticated.
     *
     * @param  Request  $request
     * @param  $user
     * @return bool
     */
    protected function authenticated(Request $request, $user)
    {
        if (! empty($user->name)) {
            Log::info('User logged in : '.$user->name);

            return true;
        }

        return false;
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return RedirectResponse|JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $this->guard()->user();

        if ($user === null) {
            return $request->wantsJson() ? new JsonResponse([], 204) : redirect(route('boilerplate.login'));
        }

        Log::info('User logged out : '.$user->name);

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson() ? new JsonResponse([], 204) : redirect(route('boilerplate.login'));
    }

    /**
     * Get the maximum number of attempts to allow.
     *
     * @return Repository|Application|mixed
     */
    public function maxAttempts()
    {
        return config('boilerplate.auth.throttle.maxAttempts', 3);
    }

    /**
     * Get the number of minutes to throttle for.
     *
     * @return Repository|Application|mixed
     */
    public function decayMinutes()
    {
        return config('boilerplate.auth.throttle.decayMinutes', 1);
    }
}
