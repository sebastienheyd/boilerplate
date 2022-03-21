<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class PasswordComposer extends ComponentComposer
{
    protected $props = [
        'check',
        'class',
        'groupClass',
        'group-class',
        'groupId',
        'group-id',
        'label',
        'length',
        'name',
        'value',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        $view->with('name', $data['name'] ?? '');
        $view->with('check', $data['check'] ?? true);
        $view->with('length', $data['length'] ?? 8);

        if (isset($data['placeholder'])) {
            $this->attributes['placeholder'] = __($data['placeholder']);
        }

        $view->with('attributes', $this->attributes);
        $view->with('nameDot', dot_str($data['name'] ?? ''));
    }
}
