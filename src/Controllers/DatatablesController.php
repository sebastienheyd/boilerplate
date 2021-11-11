<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class DatatablesController extends Controller
{
    public function __invoke(Request $request, $slug)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $datatable = $this->getDatatable($slug);

        return ($datatable)->make();
    }

    private function getDatatable($slug)
    {
        $datatable = app('boilerplate.datatables')->load(app_path('Datatables'))->getDatatable($slug);

        if (! $datatable) {
            abort(404);
        }

        return $datatable;
    }

    private function getSearchable(Datatable $datatable)
    {
        $searchable = [];

        foreach ($datatable->columns() as $column) {
            if ($column->searchable === false) {
                continue;
            }

            $searchable[$column->data] = $column->title;
        }

        return $searchable;
    }

    public function options(Request $request, $slug)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $q = $request->post('q');
        $id = $request->post('id');

        $datatable = $this->getDatatable($slug);
        $searchable = $this->getSearchable($datatable);

        $already = explode(',', $request->post('already'));
        foreach ($already as $option) {
            if (isset($searchable[$option])) {
                unset($searchable[$option]);
            }
        }

        return view('boilerplate::datatables.options', compact('q', 'searchable', 'slug', 'id'));
    }

    public function facet(Request $request, $slug)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $datatable = $this->getDatatable($slug);
        $searchable = $this->getSearchable($datatable);

        $field = $request->post('field');
        $label = $searchable[$field];
        $value = $request->post('value');
        return view('boilerplate::datatables.facet', compact('field', 'value', 'label'));
    }
}
