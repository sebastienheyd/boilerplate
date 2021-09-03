<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DatepickerComposer extends ComponentComposer
{
    protected $props = [
        'format',
        'group-class',
        'groupClass',
        'group-id',
        'groupId',
        'help',
        'id',
        'label',
        'name',
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

        if (!empty($data['value'])) {
            if (preg_match('#[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}#', $data['value'])) {
                $rawValue = $data['value'];
                $data['value'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['value'])->isoFormat($data['format']);
            }

            if (preg_match('#[0-9]{4}-[0-9]{2}-[0-9]{2}#', $data['value'])) {
                $rawValue = $data['value'];
                $data['value'] = Carbon::createFromFormat('Y-m-d', $data['value'])->isoFormat($data['format']);
            }
        }

        $view->with('value', $data['value'] ?? null);
        $view->with('rawValue', $rawValue ?? $data['value'] ?? null);

        if (empty($data['id'])) {
            $view->with('id', uniqid('datepicker'));
        }

        $view->with('attributes', $this->attributes);
    }
}
