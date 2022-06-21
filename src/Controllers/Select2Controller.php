<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Http\Request;
use Sebastienheyd\Boilerplate\View\Composers\Select2Composer;

class Select2Controller
{
    public function make(Request $request)
    {
        // Only ajax calls
        if (! $request->isXmlHttpRequest()) {
            abort(404);
        }

        // Check model format
        if (! preg_match(Select2Composer::$regex, decrypt($request->post('m')), $m)) {
            abort(500);
        }

        $model = $m[1];
        $key = $m[4] ?? (new $model)->getKeyName();
        $q = str_replace(' ', '%', $request->post('q'));
        $query = $model::query()->limit($request->post('length', 10));

        // The model has a scope ?
        if (method_exists($model, 'scope'.$m[2])) {
            $query->{lcfirst($m[2])}($q);

            $results = $query->get()->map(function ($item) {
                return [
                    'id' => $item->select2_id,
                    'text' => $item->select2_text,
                ];
            });
        } else {
            // Generic query
            $query->selectRaw(
                '`'.$key.'`,`'.$m[2].'`,
                CASE WHEN '.$m[2].' LIKE "'.$q.'%" THEN 100 ELSE 0 END AS m1,
                CASE WHEN '.$m[2].' LIKE "%'.$q.'%" THEN 50 ELSE 0 END AS m2'
            )
            ->where(\DB::raw($m[2]), 'like', "%$q%")
            ->orderBy('m1', 'desc')
            ->orderBy('m2', 'desc')
            ->orderBy($m[2], 'asc');

            $results = $query->get()->map(function ($item) use ($m, $key) {
                return [
                    'id' => $item->{$key},
                    'text' => $item->{$m[2]},
                ];
            });
        }

        return response()->json([
            'results' => $results->toArray(),
        ]);
    }
}
