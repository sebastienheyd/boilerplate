<?php

namespace Sebastienheyd\Boilerplate\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BoilerplateImpersonate
{
    /**
     * Check if the impersonate attribute of the session is set. If so, authenticate once as that user and continue.
     *
     * @param $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('impersonate')) {
            config([
                'laratrust.middleware.handling' => 'redirect',
                'laratrust.middleware.handlers.redirect.url' => route('boilerplate.impersonate.unauthorized', [], false),
            ]);

            View::share('impersonator', Auth::user());
            Auth::onceUsingId(session()->get('impersonate'));
        }

        return $next($request);
    }
}
