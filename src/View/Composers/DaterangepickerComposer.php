<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class DaterangepickerComposer extends ComponentComposer
{
    protected $props = [
        'append',
        'appendText',
        'append-text',
        'class',
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
        'timePicker',
        'timePickerIncrement',
        'timePicker24Hour',
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

        if (($data['timePicker'] ?? false) === true) {
            $format = __('boilerplate::date.YmdHi');

            if (($data['timePickerSeconds'] ?? false) === true) {
                $format = __('boilerplate::date.YmdHis');
            }

            if (($data['timePicker24Hour'] ?? true) === false) {
                $format = __('boilerplate::date.YmdhiA');

                if (($data['timePickerSeconds'] ?? false) === true) {
                    $format = __('boilerplate::date.YmdhisA');
                }
            }
        }

        $view->with('format', $format);
        $view->with('value', $data['value'] ?? null);
        $view->with('id', $data['id'] ?? uniqid('datetimepicker_'));
        $view->with('attributes', $this->attributes);
    }
}
