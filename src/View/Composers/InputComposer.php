<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\Support\Str;
use Illuminate\View\View;

class InputComposer extends ComponentComposer
{
    protected $props = [
        'append',
        'appendText',
        'append-text',
        'class',
        'clearable',
        'errors',
        'groupClass',
        'group-class',
        'groupId',
        'group-id',
        'help',
        'inputGroupClass',
        'input-group-class',
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

        foreach (['append', 'prepend', 'prependText', 'appendText', 'append-text', 'prepend-text'] as $p) {
            $p = Str::camel($p);
            if (! isset($data[$p])) {
                $view->with($p, false);
            } elseif (in_array($p, ['prependText', 'appendText']) && preg_match('#^fa[srb]? fa-.+$#', $data[$p])) {
                $view->with($p, '<span class="'.$data[$p].'"></span>');
            }
        }

        if (isset($data['placeholder'])) {
            $this->attributes['placeholder'] = __($data['placeholder']);
        }

        if (! isset($data['autocomplete'])) {
            $this->attributes['autocomplete'] = 'off';
        }

        $view->with('nameDot', dot_str($data['name'] ?? ''));
        $view->with('attributes', $this->attributes);
    }
}
