<?php

namespace Sebastienheyd\Boilerplate\Dashboard;

abstract class Widget
{
    protected $slug;
    protected $label;
    protected $description;
    protected $permission;

    abstract public function render();

    public function __get($prop)
    {
        if ($prop === 'label' || $prop === 'description') {
            return __($this->{$prop}) ?: static::class.' → '.$prop;
        }

        if (property_exists($this, $prop)) {
            return $this->{$prop};
        }

        return null;
    }
}