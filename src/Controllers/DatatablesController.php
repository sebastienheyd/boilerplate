<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use ReflectionException;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class DatatablesController extends Controller
{
    /**
     * Rendering DataTable.
     *
     * @param  Request  $request
     * @param  string  $slug
     * @throws ReflectionException
     * @return mixed
     */
    public function __invoke(Request $request, string $slug)
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

    /**
     * Get array of searchable fields.
     *
     * @param  Datatable  $datatable
     * @return array
     */
    private function getSearchable(Datatable $datatable)
    {
        $searchable = [];

        foreach ($datatable->columns() as $k => $column) {
            if ($column->searchable === false) {
                continue;
            }

            $searchable[$k] = $column->title;
        }

        return $searchable;
    }

    /**
     * Rendering available filter options for autocomplete.
     *
     * @param  Request  $request
     * @param  string  $slug
     * @throws ReflectionException
     * @return Application|Factory|View
     */
    public function options(Request $request, string $slug)
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

    /**
     * Rendering a facet.
     *
     * @param  Request  $request
     * @param  string  $slug
     * @throws ReflectionException
     * @return Application|Factory|View
     */
    public function facet(Request $request, string $slug)
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

    public function search(Request $request, string $slug)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $datatable = $this->getDatatable($slug);

        return view('boilerplate::datatables.search', compact('slug'));
    }
}
