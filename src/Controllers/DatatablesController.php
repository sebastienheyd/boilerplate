<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DatatablesController extends Controller
{
    public function __invoke(Request $request, $slug = null)
    {
        $datatables = app('boilerplate.datatables')->load(app_path('Datatables'))->getDatatables();

        if (! isset($datatables[$slug])) {
            abort(404);
        }

        return ($datatables[$slug])->make();
    }
}
