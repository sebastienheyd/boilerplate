<?php

namespace Sebastienheyd\Boilerplate\Datatables;

use Closure;

class Column
{
    protected $title         = '';
    protected $raw           = null;
    protected $filter        = null;
    protected $actions       = [];
    protected $filterOptions = [];
    protected $attributes    = [];

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public static function add(string $title = ''): Column
    {
        return new static($title);
    }

    public function get()
    {
        $attributes = [];
        foreach ($this->attributes as $k => $v) {
            if (is_string($v)) {
                $attributes[] = "$k:\"$v\"";
            } elseif ($v instanceof Closure) {
                $attributes[] = "$k:".$v();
            } elseif (is_bool($v)) {
                $attributes[] = "$k:".($v ? 'true' : 'false');
            } else {
                $attributes[] = "$k:".intval($v);
            }
        }
        return '{'.implode(',', $attributes).'}';
    }

    public function data(string $name, Closure $format = null): Column
    {
        $this->attributes['data'] = $name;

        if ($format !== null) {
            $this->raw = $format;
        }

        return $this;
    }

    public function filterOptions($filterOptions)
    {
        if (is_array($filterOptions)) {
            $this->filterOptions = $filterOptions;
        }

        if ($filterOptions instanceof Closure) {
            $this->filterOptions = $filterOptions->call($this);
        }

        return $this;
    }

    public function fromNow()
    {
        return $this->dateFormat(function () {
            return "$.fn.dataTable.render.fromNow()";
        });
    }

    public function dateFormat($format = null)
    {
        if ($format === null) {
            $format = __('boilerplate::date.YmdHis');
        }

        if (is_string($format)) {
            $format = function () use ($format) {
                return "$.fn.dataTable.render.moment('$format')";
            };
        }

        if ($format instanceof Closure) {
            $this->attributes['render'] = $format;
        }

        $this->filter(function ($query, $q) {
            [$start, $end] = explode('|', $q);
            $query->whereBetween($this->data, [$start, $end]);
        });

        return $this;
    }

    public function filter(Closure $filter)
    {
        $filter = Closure::bind($filter, $this);
        $this->filter = $filter;

        return $this;
    }

    public function actions(Closure $actions)
    {
        $this->data('dt-actions', $actions)->class('visible-on-hover text-nowrap')->notSearchable()->notOrderable();

        return $this;
    }

    public function class(string $class): Column
    {
        $this->attributes['class'] = $class;

        return $this;
    }

    public function name(string $name): Column
    {
        $this->attributes['name'] = $name;

        return $this;
    }

    public function width(string $width): Column
    {
        $this->attributes['width'] = $width;

        return $this;
    }

    public function hidden(): Column
    {
        return $this->booleanAttribute('visible', false);
    }

    private function booleanAttribute($name, $value): Column
    {
        $this->attributes[$name] = false;

        if ($value === true) {
            unset($this->attributes[$name]);
        }

        return $this;
    }

    public function notSearchable(): Column
    {
        return $this->booleanAttribute('searchable', false);
    }

    public function notSortable(): Column
    {
        return $this->booleanAttribute('sortable', false);
    }

    public function notOrderable(): Column
    {
        return $this->booleanAttribute('orderable', false);
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

    public function __isset($name)
    {
        if (property_exists($this, $name)) {
            return ! empty($this->$name);
        }

        return isset($this->attributes[$name]);
    }
}
