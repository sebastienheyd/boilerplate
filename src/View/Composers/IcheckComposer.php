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

        if (empty($data['id'])) {
            $view->with('id', uniqid('icheck_'));
        }

        if (empty($data['checked']) || $data['checked'] === false) {
            $view->with('checked', false);
        }

        if (empty($data['disabled']) || $data['disabled'] === false) {
            $view->with('disabled', false);
        }

        foreach (['class', 'name', 'value'] as $empty) {
            if (empty($data[$empty])) {
                $view->with($empty, '');
            }
        }
    }
}
