<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class InputComposer extends ComponentComposer
{
    protected $props = [
        'type',
        'name',
        'label',
        'value',
        'errors',
        'class',
        'help',
        'options',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        if (! isset($data['type'])) {
            $view->with('type', 'text');
        }

        $view->with('attributes', $this->attributes);
    }
}
