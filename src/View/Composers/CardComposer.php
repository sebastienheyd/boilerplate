<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class CardComposer extends ComponentComposer
{
    protected $props = [
        'bg-color',
        'class',
        'close',
        'collapsed',
        'color',
        'footer',
        'header',
        'maximize',
        'outline',
        'reduce',
        'slot',
        'tabs',
        'title',
        'tools',
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
        foreach (['maximize', 'reduce', 'close', 'collapsed'] as $action) {
            $view->with($action, isset($data[$action]));
        }

        $view->with('header', $data['header'] ?? false);
        $view->with('class', $data['class'] ?? '');
        $view->with('tabs', $data['tabs'] ?? false);
    }
}
