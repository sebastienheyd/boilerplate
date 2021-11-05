<?php

namespace Sebastienheyd\Boilerplate\Datatables;

class Column
{
    protected $title = '';

    protected $attributes = [
        'data' => '',
    ];

    public static function add(string $title): Column
    {
        return new static($title);
    }

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function title(string $title): Column
    {
        $this->title = __($title);

        return $this;
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

    public function visible(bool $visible = true): Column
    {
        return $this->booleanAttribute('visible', $visible);
    }

    public function searchable(bool $searchable = true): Column
    {
        return $this->booleanAttribute('searchable', $searchable);
    }

    public function sortable(bool $sortable = true): Column
    {
        return $this->booleanAttribute('sortable', $sortable);
    }

    public function orderable(bool $orderable = true): Column
    {
        return $this->booleanAttribute('orderable', $orderable);
    }

    private function booleanAttribute($name, $value): Column
    {
        $this->attributes[$name] = false;

        if ($value === true) {
            unset($this->attributes[$name]);
        }

        return $this;
    }
}
