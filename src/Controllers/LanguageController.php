<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch language.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function switch(Request $request): JsonResponse
    {
        if (in_array($request->post('lang'), config('boilerplate.locale.allowed'))) {
            setting(['locale' => $request->post('lang')]);
            cookie()->forever('boilerplate_lang', $request->post('lang'));

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);

    }
}
