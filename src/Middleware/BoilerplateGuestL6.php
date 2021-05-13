<?php

namespace Sebastienheyd\Boilerplate\Middleware;

use App\Http\Middleware\RedirectIfAuthenticated as Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoilerplateGuestL6 extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request      $request
     * @param  Closure     $next
     * @param  string|null ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(route('boilerplate.dashboard'));
            }
        }

        return $next($request);
    }
}
