<?php

namespace Sebastienheyd\Boilerplate\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $color;
    public $bgColor;
    public $title;
    public $tabs;
    public $outline;
    public $maximize;
    public $reduce;
    public $close;
    public $collapsed;
    public $class;

    public function __construct(
        $color = null,
        $title = null,
        $tabs = false,
        $outline = null,
        $bgColor = null,
        $maximize = null,
        $reduce = null,
        $close = null,
        $collapsed = null,
        $class = null
    ) {
        $this->color = $color ?? config('boilerplate.theme.card.default_color', 'info');
        $this->title = $title;
        $this->tabs = $tabs ? true : null;
        $this->outline = config('boilerplate.theme.card.outline', false);
        $this->bgColor = $bgColor ?? 'white';
        $this->maximize = $maximize;
        $this->reduce = $reduce;
        $this->close = $close;
        $this->collapsed = $collapsed;
        $this->class = $class;

        if ($outline !== null) {
            $this->outline = ! (($outline === false || $outline === 'false'));
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('boilerplate::components.card');
    }
}
