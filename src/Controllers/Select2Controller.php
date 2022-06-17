<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Http\Request;

class Select2Controller
{
    public function make(Request $request)
    {
        // Only ajax calls
        if (! $request->isXmlHttpRequest()) {
            abort(404);
        }

        // Check model format
        if (! preg_match('#^([^,]+),([A-Za-z0-9_\-]+)(,([A-Za-z0-9_\-]+))?$#', $request->post('model'), $m)) {
            abort(500);
        }

        // Check signature to avoid using of forbidden fields
        if (decrypt($request->post('s', '')) !== $request->post('model')) {
            abort(500);
        }

        $model = $m[1];
        $key = $m[4] ?? (new $model)->getKeyName();
        $q = $request->post('q');

        return response()->json([
            'results' => $model::query()
                ->selectRaw(
                    $key.' as id,
                    '.$m[2].' as text, 
                    CASE WHEN '.$m[2].' LIKE "'.$q.'%" THEN 100 ELSE 0 END AS m1,
                    CASE WHEN '.$m[2].' LIKE "%'.$q.'%" THEN 50 ELSE 0 END AS m2'
                )
                ->where($m[2], 'like', "%$q%")
                ->orderBy('m1', 'desc')
                ->orderBy('m2', 'desc')
                ->orderBy('text', 'asc')
                ->limit($request->post('length', 10))
                ->get()
                ->toArray(),
        ]);
    }
}
