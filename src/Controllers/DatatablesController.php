<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ReflectionException;

class DatatablesController
{
    /**
     * Rendering DataTable.
     *
     * @param  Request  $request
     * @param  string  $slug
     * @return mixed
     *
     * @throws ReflectionException
     */
    public function make(Request $request, string $slug)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $datatable = $this->getDatatable($slug);

        if (! Auth::user()->ability(['admin'], $datatable->permissions)) {
            abort(503);
        }

        return ($datatable)->make();
    }

    /**
     * Get DataTable class for the given slug.
     *
     * @param  string  $slug
     * @return false|mixed
     *
     * @throws ReflectionException
     */
    private function getDatatable(string $slug)
    {
        $datatable = app('boilerplate.datatables')->load(app_path('Datatables'))->getDatatable($slug);

        if (! $datatable) {
            abort(404);
        }

        return $datatable;
    }
}
