<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class DatatableComposer
{
    public function compose(View $view)
    {
        $datatables = app('boilerplate.datatables')->load(app_path('Datatables'))->getDatatables();
    }
}
