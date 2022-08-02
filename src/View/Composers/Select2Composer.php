<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;

class Select2Composer extends ComponentComposer
{
    public static $regex = '#^([^,|]+)[,|]([A-Za-z0-9_\-]+)([,|]([A-Za-z0-9_\-]+))?$#';

    protected $props = [
        'ajax-params',
        'allow-clear',
        'class',
        'errors',
        'groupClass',
        'group-class',
        'groupId',
        'group-id',
        'help',
        'id',
        'label',
        'maxLength',
        'max-length',
        'minimum-input-length',
        'minimum-results-for-search',
        'model',
        'name',
        'options',
        'placeholder',
        'selected',
        'tags',
    ];

    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        if (! empty($data['model'])) {
            if (! preg_match(self::$regex, $data['model'], $m)) {
                throw new \ErrorException('Select2 component model format is incorrect');
            }

            $view->with('name', $data['name'] ?? strtolower(class_basename($m[1])));
            $view->with('model', encrypt($data['model']));
            $view->with('ajax', route('boilerplate.select2', [], false));

            if ($data['selected'] ?? false) {
                $key = $m[4] ?? (new $m[1])->getKeyName();
                $view->with('options', (new $m[1])
                    ->whereIn($key, is_array($data['selected']) ? $data['selected'] : [$data['selected']])
                    ->pluck($m[2], $key)
                    ->toArray());
            }
        }

        if (empty($data['id'])) {
            $view->with('id', uniqid('select2_'));
        }

        $view->with('allowClear', isset($data['allowClear']) ? 'true' : 'false');
        $view->with('tags', isset($data['tags']) ? 'true' : 'false');
        $view->with('nameDot', dot_str($data['name'] ?? ''));
        $view->with('ajaxParams', $data['ajaxParams'] ?? []);
    }
}
