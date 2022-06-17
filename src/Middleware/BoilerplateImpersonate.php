<?php

namespace Sebastienheyd\Boilerplate\Middleware;

use Closure;
use Auth;

class BoilerplateImpersonate
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('impersonate'))
        {
            Auth::onceUsingId($request->session()->get('impersonate'));
        }

        return $next($request);
    }
}