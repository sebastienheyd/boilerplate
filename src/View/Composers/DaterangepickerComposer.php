<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class DaterangepickerComposer extends ComponentComposer
{
    protected $props = [
        'alignment',
        'append',
        'append-text',
        'appendText',
        'class',
        'control-class',
        'controlClass',
        'end',
        'group-class',
        'group-id',
        'groupClass',
        'groupId',
        'help',
        'id',
        'label',
        'max-date',
        'maxDate',
        'min-date',
        'minDate',
        'name',
        'prepend',
        'prepend-text',
        'prependText',
        'start',
        'timePicker',
        'timePicker24Hour',
        'timePickerIncrement',
        'timePickerSeconds',
        'value',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        $this->appendPrependText($view);

        if (! isset($this->attributes['autocomplete'])) {
            $this->attributes['autocomplete'] = 'off';
        }

        $format = __('boilerplate::date.Ymd');

        if (isset($data['minDate'])) {
            $date = $this->dateToCarbon($data['minDate']);
            $view->with('minDate', $date->format('Y-m-d H:i:s'));
        }

        if (isset($data['maxDate'])) {
            $date = $this->dateToCarbon($data['maxDate']);
            $view->with('maxDate', $date->format('Y-m-d H:i:s'));
        }

        if (bool($data['timePicker'] ?? false)) {
            $format = __('boilerplate::date.YmdHi');

            if (bool($data['timePickerSeconds'] ?? false)) {
                $format = __('boilerplate::date.YmdHis');
            }

            if (! bool($data['timePicker24Hour'] ?? true)) {
                $format = __('boilerplate::date.YmdhiA');

                if (bool($data['timePickerSeconds'] ?? false)) {
                    $format = __('boilerplate::date.YmdhisA');
                }
            }
        }

        $view->with('format', $format);
        $view->with('value', $data['value'] ?? null);
        $view->with('id', $data['id'] ?? uniqid('datetimepicker_'));
        $view->with('attributes', $this->attributes);
        $view->with('nameDot', dot_str($data['name'] ?? ''));
    }
}
