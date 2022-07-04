<?php

namespace Sebastienheyd\Boilerplate\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BoilerplateLocale
{
    /**
     * Set Boilerplate locale.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        App::setLocale(config('boilerplate.app.locale', config('app.locale')));
        Carbon::setLocale(config('boilerplate.app.locale', config('app.locale')));

        if (! config('boilerplate.locale.switch')) {
            return $next($request);
        }

        $lang = setting('locale', $request->cookie('boilerplate_lang'));

        if (in_array($lang, config('boilerplate.locale.allowed'))) {
            App::setLocale($lang);
            Carbon::setLocale($lang);
        }

        return $next($request);
    }
}
