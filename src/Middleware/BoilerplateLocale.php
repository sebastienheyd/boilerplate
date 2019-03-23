<?php

namespace Sebastienheyd\Boilerplate\Middleware;

use Carbon\Carbon;
use Closure;

class BoilerplateLocale
{
    /**
     * Set Boilerplate locale.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app()->setLocale(config('boilerplate.app.locale', config('app.locale')));
        Carbon::setLocale(config('boilerplate.app.locale', config('app.locale')));

        return $next($request);
    }
}
