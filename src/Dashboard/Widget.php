<?php

namespace Sebastienheyd\Boilerplate\Dashboard;

abstract class Widget
{
    protected $slug;
    protected $label;
    protected $description;
    protected $permission;
    protected $size = 'md';
    protected $width;
    protected $parameters = [];

    abstract public function render();

    public function make($params = [])
    {
        foreach ($params as $k => $v) {
            if (in_array($k, array_keys($this->parameters))) {
                $this->parameters[$k] = $v;
            }
        }

        return $this->render();
    }

    public function __get($prop)
    {
        if ($prop === 'label' || $prop === 'description') {
            return __($this->{$prop}) ?: static::class.' → '.$prop;
        }

        if ($prop === 'width' && empty($this->width)) {
            $sizes = [
                'xxs' => ['sm' => 4, 'md' => 4, 'xl' => 2, 'xxl' => 2],
                'xs' => ['sm' => 6, 'md' => 6, 'xl' => 4, 'xxl' => 3],
                'sm' => ['sm' => 12, 'md' => 6, 'xl' => 6, 'xxl' => 4],
                'md' => ['sm' => 12, 'md' => 6, 'xl' => 6, 'xxl' => 6],
                'xl' => ['sm' => 12, 'md' => 12, 'xl' => 8, 'xxl' => 8],
                'xxl' => ['sm' => 12, 'md' => 12, 'xl' => 12, 'xxl' => 12],
            ];

            return $sizes[$this->size] ?? ['sm' => 6, 'md' => 6, 'xl' => 4, 'xxl' => 3];
        }

        if (property_exists($this, $prop)) {
            return $this->{$prop};
        }

        return null;
    }
}