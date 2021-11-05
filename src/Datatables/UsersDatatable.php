<?php

namespace Sebastienheyd\Boilerplate\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Datatable;

class UsersDatatable extends Datatable
{
    protected $signature = 'users';

    public function columns()
    {
        Column::add('Id')->field('id');
    }
}