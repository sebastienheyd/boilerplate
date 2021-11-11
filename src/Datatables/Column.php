<?php

namespace Sebastienheyd\Boilerplate\Datatables;

use Closure;

class Column
{
    public $title = '';
    public $raw   = null;

    protected $attributes = [];

    public static function add(string $title = ''): Column
    {
        return new static($title);
    }

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function get()
    {
        $attributes = [];
        foreach ($this->attributes as $k => $v) {
            if (is_string($v)) {
                $attributes[] = "$k:\"$v\"";
            } elseif ($v instanceof Closure) {
                $attributes[] = "$k:".$v();
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

        return $this;
    }

    public function fromNow()
    {
        return $this->dateFormat(function () {
            return "$.fn.dataTable.render.fromNow()";
        });
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

    private function booleanAttribute($name, $value): Column
    {
        $this->attributes[$name] = false;

        if ($value === true) {
            unset($this->attributes[$name]);
        }

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
