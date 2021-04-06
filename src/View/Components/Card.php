<?php

namespace Sebastienheyd\Boilerplate\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $color;
    public $title;
    public $tabs;

    public function __construct($color = null, $title = null, $tabs = false)
    {
        $this->color = $color ?? config('boilerplate.theme.card.default_color', 'info');
        $this->title = $title;
        $this->tabs = $tabs ? true : null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('boilerplate::card');
    }
}
