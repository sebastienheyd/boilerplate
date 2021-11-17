<?php

namespace Sebastienheyd\Boilerplate\Datatables;

class Button
{
    protected $icon = 'pencil-alt';
    protected $class = 'default';
    protected $href = '#';

    public function __construct(string $icon)
    {
        $this->icon = $icon;
    }

    public static function add(string $icon = ''): Button
    {
        return new static($icon);
    }

    public function class(string $class)
    {
        $this->class = $class;

        return $this;
    }

    public function link(string $href)
    {
        $this->href = $href;

        return $this;
    }

    public function route($route, $args = [])
    {
        return $this->link(route($route, $args, false));
    }

    public function make()
    {
        $str = '<a href="%s" class="btn btn-sm btn-%s"><i class="fa fa-fw fa-%s"></i></a>';

        return sprintf($str, $this->href, $this->class, $this->icon);
    }
}