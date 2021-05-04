<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class InfoboxComposer extends ComponentComposer
{
    protected $props = [
        'bg-color',
        'color',
        'class',
        'description',
        'icon',
        'number',
        'progress',
        'text',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        if (empty($data['class'])) {
            $view->with('class', '');
        }
    }
}
