<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class SmallboxComposer extends ComponentComposer
{
    protected $props = [
        'class',
        'color',
        'nb',
        'text',
        'link',
        'link-text',
        'icon',
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
