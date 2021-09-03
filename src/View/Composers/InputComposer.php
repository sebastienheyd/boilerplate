<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class InputComposer extends ComponentComposer
{
    protected $props = [
        'append',
        'appendText',
        'append-text',
        'class',
        'errors',
        'groupClass',
        'group-class',
        'groupId',
        'group-id',
        'help',
        'label',
        'name',
        'options',
        'prepend',
        'prepend-text',
        'prependText',
        'type',
        'value',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        if (! isset($data['type'])) {
            $view->with('type', 'text');
        }

        foreach (['append', 'prepend', 'prependText', 'appendText'] as $prop) {
            if (! isset($data[$prop])) {
                $view->with($prop, false);
            } elseif (in_array($prop, ['prependText', 'appendText']) && preg_match('#^fa[srb] fa-.+$#', $data[$prop])) {
                $view->with($prop, '<span class="'.$data[$prop].'"></span>');
            }
        }

        if (isset($data['placeholder'])) {
            $this->attributes['placeholder'] = __($data['placeholder']);
        }

        $view->with('attributes', $this->attributes);
    }
}
