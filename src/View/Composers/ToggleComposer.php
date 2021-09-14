<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class ToggleComposer extends ComponentComposer
{
    protected $props = [
        'class',
        'colorOn',
        'color-on',
        'colorOff',
        'color-off',
        'id',
        'label',
        'checked',
        'name',
        'type',
        'value',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        $view->with('id', $data['id'] ?? uniqid('toggle_'));
        $view->with('checked', $data['checked'] ?? false);

        foreach (['class', 'name', 'value'] as $empty) {
            $view->with($empty, $data[$empty] ?? '');
        }
    }
}
