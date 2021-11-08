<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class DatatableComposer extends ComponentComposer
{
    protected $props = [
        'name'
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        $datatables = app('boilerplate.datatables')->load(app_path('Datatables'))->getDatatables();

        if (! empty($data['name']) && ! isset($datatables[$data['name']])) {
            return;
        }

        if (empty($data['id'])) {
            $view->with('id', uniqid('datatable_'));
        }

        $datatable = $datatables[$data['name']];
        $datatable->setUp();

        $view->with('datatable', $datatable);
    }
}
