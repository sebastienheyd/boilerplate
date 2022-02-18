<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Str;

class DatatableComposer extends ComponentComposer
{
    protected $props = [
        'name',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        $datatables = app('boilerplate.datatables')->load(app_path('Datatables'))->getDatatables();

        if (! empty($data['name']) && ! isset($datatables[$data['name']])) {
            throw new \Exception('DataTable class for "'.$data['name'].'" is not found');
        }

        $datatable = $datatables[$data['name']];
        $datatable->setUp();

        if (empty($data['id'])) {
            $view->with('id', 'dt_'.Str::snake(Str::camel($datatable->slug)), '_');
        }

        $view->with('permission', Auth::user()->ability(['admin'], $datatable->permissions));
        $view->with('ajax', $data['ajax'] ?? []);
        $view->with('datatable', $datatable);
    }
}
