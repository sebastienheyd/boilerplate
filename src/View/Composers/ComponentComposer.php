<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\View;

abstract class ComponentComposer
{
    protected $props = [];
    protected $attributes = [];

    /**
     * For Laravel 6, replace @props directive to specify which attribute should be considered as data variables
     *
     * @param View $view
     *
     * @return View
     */
    public function compose(View $view)
    {
        $attributes = $view->getData();

        if (isset($attributes['attributes']) && $attributes['attributes'] instanceof ComponentAttributeBag) {
            $attributes = iterator_to_array($attributes['attributes']->getIterator(), true);
        }

        $filter = array_merge($this->props, ['componentName', 'slot', '__laravel_slots']);

        foreach ($attributes as $k => $v) {
            if (!in_array($k, $filter)) {
                continue;
            }

            if (strpos($k, '-')) {
                $view->offsetUnset($k);
                $view->with(Str::camel($k), $v);
            }

            unset($attributes[$k]);
        }

        $this->attributes = $attributes;

        $attributes = implode(' ', array_map(function ($k, $v) {
            if ($v === true || empty($v)) {
                return $k;
            }

            if (! is_string($v)) {
                return '';
            }

            return $k.'="'.htmlspecialchars($v).'"';
        }, array_keys($attributes), $attributes));

        return $view->with('attributes', $attributes);
    }
}
