<?php

namespace Sebastienheyd\Boilerplate\Datatables;

use Yajra\DataTables\Facades\DataTables;

abstract class Datatable
{
    public    $slug          = '';
    public    $datasource;
    public    $perPageValues = [10, 25, 50, 100, 0];
    protected $attributes    = [
        'ordering'     => true,
        'paging'       => true,
        'pageLength'   => 10,
        'lengthChange' => true,
        'searching'    => true,
        'stateSave'    => false,
        'info'         => true,
    ];

    public function datasource()
    {
        return null;
    }

    public function columns()
    {
        return [];
    }

    public function setUp()
    {

    }

    public function make()
    {
        $datatable = DataTables::of($this->datasource());

        $raw = [];
        foreach ($this->columns() as $column) {
            if ($column->raw) {
                $raw[] = $column->data;
                $datatable->editColumn($column->data, $column->raw);
            }
        }

        if (! empty($raw)) {
            $datatable->rawColumns($raw);
        }

        return $datatable->make(true);
    }

    public function pageLength(int $length = 10): Datatable
    {
        $this->attributes['pageLength'] = $length;

        return $this;
    }

    public function stateSave(): Datatable
    {
        $this->attributes['stateSave'] = true;

        return $this;
    }

    public function noPaging(): Datatable
    {
        $this->attributes['paging'] = false;

        return $this;
    }

    public function noLengthChange(): Datatable
    {
        $this->attributes['lengthChange'] = false;

        return $this;
    }

    public function noOrdering(): Datatable
    {
        $this->attributes['ordering'] = false;

        return $this;
    }

    public function noSearching(): Datatable
    {
        $this->attributes['searching'] = false;

        return $this;
    }

    public function noInfo(): Datatable
    {
        $this->attributes['info'] = false;

        return $this;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }
}