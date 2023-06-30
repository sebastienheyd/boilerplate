<?php

namespace Sebastienheyd\Boilerplate\Dashboard;

abstract class Widget
{
    protected $label;
    protected $permission;

    abstract public function render();

    public function __get($prop)
    {
        if ($prop === 'label') {
            return __($this->label) ?? static::class;
        }

        if (property_exists($this, $prop)) {
            return $this->{$prop};
        }

        return null;
    }
}