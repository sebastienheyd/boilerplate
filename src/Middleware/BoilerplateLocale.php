<?php

namespace Sebastienheyd\Boilerplate\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\App;

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
        App::setLocale(config('boilerplate.locale.default', config('app.locale')));
        Carbon::setLocale(config('boilerplate.locale.default', config('app.locale')));

        if (! Session()->has('boilerplate_locale')) {
            return $next($request);
        }

        if (in_array(Session()->get('boilerplate_locale'), config('boilerplate.locale.allowed'))) {
            App::setLocale(Session()->get('boilerplate_locale'));
            Carbon::setLocale(Session()->get('boilerplate_locale'));
        }

        return $next($request);
    }
}
