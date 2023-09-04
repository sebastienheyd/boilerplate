<?php

namespace Sebastienheyd\Boilerplate\Dashboard;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class DashboardWidgetsRepository
{
    protected $widgets = [];

    /**
     * Register one or more widget classes.
     *
     * @param  ...$class
     * @return $this
     *
     * @throws ReflectionException
     */
    public function registerWidget(...$class)
    {
        foreach ($class as $c) {
            if (! is_subclass_of($c, Widget::class)) {
                continue;
            }

            $widget = new $c;

            $this->widgets[$widget->slug] = $widget;
        }

        return $this;
    }

    /**
     * Get an array of the registered widgets.
     *
     * @return Widget[]
     */
    public function getWidgets()
    {
        return $this->widgets;
    }

    /**
     * Get the widget with the given slug.
     *
     * @param  string  $slug
     * @return Widget|false
     */
    public function getWidget($slug)
    {
        return $this->widgets[$slug] ?? false;
    }

    /**
     * Load widgets classes from the given paths.
     *
     * @param  string|array  $paths
     * @return $this
     */
    public function load($paths)
    {
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return $this;
        }

        $namespace = app()->getNamespace();

        foreach ((new Finder())->in($paths)->files() as $widget) {
            $widget = $namespace.str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($widget->getRealPath(), realpath(app_path()).DIRECTORY_SEPARATOR)
            );

            $this->registerWidget($widget);
        }

        return $this;
    }
}
