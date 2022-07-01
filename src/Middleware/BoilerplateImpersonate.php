<?php

namespace Sebastienheyd\Boilerplate\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BoilerplateImpersonate
{
    /**
     * Check if the impersonate attribute of the session is set. If so, authenticate once as that user and continue.
     *
     * @param $request
     * @param  Closure  $next
     * @return mixed
     *
     * @author Christopher Walker
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('impersonate')) {
            Auth::onceUsingId(session()->get('impersonate'));
        }

        return $next($request);
    }
}
