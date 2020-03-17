<?php

namespace Sebastienheyd\Boilerplate\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
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
