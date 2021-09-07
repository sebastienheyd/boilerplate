<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
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

        foreach (['append', 'prepend', 'prependText', 'appendText', 'append-text', 'prepend-text'] as $p) {
            $p = Str::camel($p);
            if (! isset($data[$p])) {
                $view->with($p, false);
            } elseif (in_array($p, ['prependText', 'appendText']) && preg_match('#^fa[srb]? fa-.+$#', $data[$p])) {
                $view->with($p, '<span class="'.$data[$p].'"></span>');
            }
        }

        if (! empty($data['value'])) {
            if (preg_match('#[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}#', $data['value'])) {
                $rawValue = $data['value'];
                $data['value'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['value'])->isoFormat($data['format']);
            }

            if (preg_match('#[0-9]{4}-[0-9]{2}-[0-9]{2}#', $data['value'])) {
                $rawValue = $data['value'];
                $data['value'] = Carbon::createFromFormat('Y-m-d', $data['value'])->isoFormat($data['format']);
            }

            if ($data['value'] instanceof Carbon) {
                $rawValue = $data['value']->format('Y-m-d H:i:s');
                $data['value'] = $data['value']->isoFormat($data['format']);
            }
        }

        $view->with('value', $data['value'] ?? null);
        $view->with('rawValue', $rawValue ?? $data['value'] ?? null);

        if (empty($data['id'])) {
            $view->with('id', uniqid('datetimepicker'));
        }

        $view->with('attributes', $this->attributes);
    }
}
