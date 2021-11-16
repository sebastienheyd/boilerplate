<?php

namespace Sebastienheyd\Boilerplate\Datatables;

use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Facades\DataTables;

abstract class Datatable
{
    public    $slug       = '';
    public    $datasource;
    protected $attributes = [
        'filters'      => true,
        'info'         => true,
        'lengthChange' => true,
        'order'        => [],
        'ordering'     => true,
        'pageLength'   => 10,
        'paging'       => true,
        'pagingType'   => 'simple_numbers',
        'searching'    => true,
        'stateSave'    => false,
        'lengthMenu'   => [10, 25, 50, 100],
    ];

    public function setUp() { }

    public function make()
    {
        /** @var EloquentDataTable $datatable */
        $datatable = DataTables::of($this->datasource());

        $raw = [];
        foreach ($this->columns() as $column) {
            if($column->filter) {
                $datatable->filterColumn($column->name, $column->filter);
            }

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

    abstract public function datasource();

    abstract public function columns(): array;

    public function order($column, $order = 'asc')
    {
        if (! is_array($column)) {
            $column = [$column => $order];
        }

        foreach ($column as $c => $o) {
            $this->attributes['order'][] = [$this->getColumnIndex($c), $o];
        }

        return $this;
    }

    private function getColumnIndex($column)
    {
        if (is_int($column)) {
            return $column;
        }

        foreach ($this->columns() as $k => $c) {
            if ($c->data === $column) {
                return $k;
            }
        }

        return 0;
    }

    public function lengthMenu(array $value)
    {
        $this->attributes['lengthMenu'] = $value;

        return $this;
    }

    public function pagingType($type)
    {
        if (in_array($type, ['numbers', 'simple', 'simple_numbers', 'full', 'full_numbers', 'first_last_numbers'])) {
            $this->attributes['pagingType'] = $type;
        }

        return $this;
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

    public function noFilters(): Datatable
    {
        $this->attributes['filters'] = false;

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

        if (in_array($name, ['order', 'lengthMenu'])) {
            return json_encode($this->attributes[$name]);
        }

        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }
}