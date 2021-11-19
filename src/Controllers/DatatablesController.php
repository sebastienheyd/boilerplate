<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Http\Request;
use ReflectionException;

class DatatablesController
{
    /**
     * Rendering DataTable.
     *
     * @param  Request  $request
     * @param  string  $slug
     * @throws ReflectionException
     * @return mixed
     */
    public function make(Request $request, string $slug)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $datatable = $this->getDatatable($slug);

        return ($datatable)->make();
    }

    /**
     * Get DataTable class for the given slug.
     *
     * @param  string  $slug
     * @throws ReflectionException
     * @return false|mixed
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
