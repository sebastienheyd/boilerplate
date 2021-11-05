<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Sebastienheyd\Boilerplate\Datatables\Column;

class DatatablesController extends Controller
{
    public function __invoke(Request $request)
    {
        $datatables = app('boilerplate.datatables')->load(app_path('Datatables'))->getDatatables();

        dd($datatables['users']);
    }
}
