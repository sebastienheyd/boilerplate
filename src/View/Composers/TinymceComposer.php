<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class TinymceComposer extends ComponentComposer
{
    protected $props = [
        'errors',
        'group-class',
        'group-id',
        'groupClass',
        'groupId',
        'help',
        'id',
        'label',
        'name',
        'sticky',
        'value',
        'minHeight',
        'min-height',
        'maxHeight',
        'max-height',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        $view->with('id', $data['id'] ?? uniqid('tinymce_'));
        $view->with('nameDot', dot_str($data['name'] ?? ''));
    }
}
