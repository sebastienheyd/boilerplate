<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\View;

abstract class ComponentComposer
{
    protected $props = [];
    protected $attributes = [];

    protected function appendPrependText(View $view)
    {
        $data = $view->getData();

        foreach (['append', 'prepend', 'prependText', 'appendText', 'append-text', 'prepend-text'] as $p) {
            $p = Str::camel($p);
            if (! isset($data[$p])) {
                $view->with($p, false);
            } elseif (in_array($p, ['prependText', 'appendText']) && preg_match('#^fa[srb]? fa-.+$#', $data[$p])) {
                $view->with($p, '<span class="'.$data[$p].'"></span>');
            }
        }
    }

    protected function dateToCarbon($date)
    {
        if (preg_match('#[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}#', $date)) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $date);
        }

        if (preg_match('#[0-9]{4}-[0-9]{2}-[0-9]{2}#', $date)) {
            return Carbon::createFromFormat('Y-m-d', $date);
        }

        if ($date instanceof Carbon) {
            return $date;
        }
    }

    /**
     * For Laravel 6, replace @props directive to specify which attribute should be considered as data variables.
     *
     * @param  View  $view
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
            if (! in_array($k, $filter)) {
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
            if ($v === true || ! isset($v)) {
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
