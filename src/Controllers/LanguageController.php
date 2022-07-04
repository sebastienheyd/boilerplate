<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    /**
     * Switch language.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function switch(Request $request): RedirectResponse
    {
        $lang = $request->post('lang');

        if (in_array($lang, config('boilerplate.locale.allowed'))) {
            setting(['locale' => $lang]);

            return Redirect::back()->withCookie(cookie()->forever('boilerplate_lang', $lang));
        }

        return Redirect::back();
    }
}
