<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class IcheckComposer extends ComponentComposer
{
    protected $props = [
        'checked',
        'class',
        'color',
        'disabled',
        'for',
        'id',
        'label',
        'name',
        'type',
        'value',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        $view->with('id', $data['id'] ?? uniqid('icheck_'));
        $view->with('checked', $data['checked'] ?? false);
        $view->with('disabled', $data['disabled'] ?? false);

        foreach (['class', 'name', 'value'] as $empty) {
            $view->with($empty, $data[$empty] ?? '');
        }
    }
}
