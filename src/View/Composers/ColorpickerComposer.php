<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class ColorpickerComposer extends ComponentComposer
{
    protected $props = [
        'name',
        'class',
        'group-class',
        'group-id',
        'groupClass',
        'groupId',
        'label',
        'control-class',
        'controlClass',
        'value',
        'selection-palette',
        'selectionPalette',
        'palette',
        'options',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();
        $view->with('id', $data['id'] ?? uniqid('colorpicker_'));
        $view->with('attributes', $this->attributes);
        $view->with('nameDot', dot_str($data['name'] ?? ''));
    }
}
