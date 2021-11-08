<?php

namespace Sebastienheyd\Boilerplate\Datatables;

class Column
{
    public $title = '';
    public $raw = null;

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
        return json_encode($this->attributes);
    }

    public function field(string $field): Column
    {
        return $this->data($field);
    }

    public function data(string $data): Column
    {
        $this->attributes['data'] = $data;

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

    public function raw($name, $function)
    {
        $this->data($name);
        $this->raw = $function;

        return $this;
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
        if(property_exists($this, $name)) {
            return $this->$name;
        }

        if(isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }
}
