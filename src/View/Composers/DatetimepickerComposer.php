<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class DatetimepickerComposer extends ComponentComposer
{
    protected $props = [
        'append',
        'appendText',
        'append-text',
        'class',
        'format',
        'group-class',
        'groupClass',
        'group-id',
        'groupId',
        'help',
        'id',
        'label',
        'name',
        'prepend',
        'prependText',
        'prepend-text',
        'show-clear',
        'showClear',
        'show-close',
        'showClose',
        'show-today',
        'showToday',
        'use-current',
        'useCurrent',
        'value',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        if (empty($data['format'])) {
            $data['format'] = 'L';
            $view->with('format', 'L');
        }

        $this->appendPrependText($view);

        if (! empty($data['value'])) {
            $date = $this->dateToCarbon($data['value']);
            $rawValue = $date->format('Y-m-d H:i:s');
            $data['value'] = $date->isoFormat($data['format']);
        }
        $view->with('value', $data['value'] ?? null);
        $view->with('rawValue', $rawValue ?? $data['value'] ?? null);
        $view->with('id', $data['id'] ?? uniqid('datetimepicker_'));
        $view->with('attributes', $this->attributes);
        $view->with('nameDot', dot_str($data['name'] ?? ''));
    }
}
