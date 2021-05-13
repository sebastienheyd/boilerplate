<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class Select2Composer extends ComponentComposer
{
    protected $props = [
        'allow-clear',
        'class',
        'errors',
        'help',
        'id',
        'label',
        'minimum-input-length',
        'name',
        'options',
        'placeholder',
        'value',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        if (empty($data['id'])) {
            $view->with('id', uniqid('select2_'));
        }

        $view->with('allowClear', isset($data['allowClear']) ? 'true' : 'false');
    }
}
