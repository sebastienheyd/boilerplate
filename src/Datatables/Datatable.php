<?php

namespace Sebastienheyd\Boilerplate\Datatables;

abstract class Datatable
{
    protected $signature = '';

    public function signature()
    {
        return $this->signature;
    }

    public function columns()
    {
        return [];
    }
}