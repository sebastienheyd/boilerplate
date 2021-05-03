<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class CardComposer extends ComponentComposer
{
    protected $props = [
        'color',
        'bg-color',
        'footer',
        'header',
        'outline',
        'slot',
        'tabs',
        'title',
        'tools',
        'maximize',
        'reduce',
        'close',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        $outline = config('boilerplate.theme.card.outline', false);

        if (array_key_exists('outline', $data)) {
            $outline = $data['outline'];
        }

        $view->with('outline', $outline);

        foreach (['maximize', 'reduce', 'close'] as $action) {
            $view->with($action, isset($data[$action]));
        }
    }
}
