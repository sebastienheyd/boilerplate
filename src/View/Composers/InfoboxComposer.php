<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class InfoboxComposer extends ComponentComposer
{
    protected $props = [
        'bg-color',
        'color',
        'icon',
        'message',
        'number',
        'progress',
        'description',
    ];

    public function compose(View $view)
    {
        parent::compose($view);
    }
}
