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
        'prepend',
        'prepend-text',
        'append',
        'append-text',
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
