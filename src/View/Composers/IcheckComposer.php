<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class IcheckComposer extends ComponentComposer
{
    protected $props = [
        'type',
        'color',
        'id',
        'label',
        'for',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        if (empty($data['id'])) {
            $view->with('id', uniqid('icheck_'));
        }
    }
}
