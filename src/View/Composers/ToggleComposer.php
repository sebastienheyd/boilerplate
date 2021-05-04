<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class ToggleComposer extends ComponentComposer
{
    protected $props = [
        'class',
        'color-on',
        'color-off',
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

        if (empty($data['id'])) {
            $view->with('id', uniqid('icheck_'));
        }

        if (empty($data['checked']) || $data['checked'] === false) {
            $view->with('checked', false);
        }

        foreach (['class', 'name', 'value'] as $empty) {
            if (empty($data[$empty])) {
                $view->with($empty, '');
            }
        }
    }
}
