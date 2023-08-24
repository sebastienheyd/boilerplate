<?php

namespace Sebastienheyd\Boilerplate\Dashboard;

class DashboardWidgetsRepository
{
    protected $widgets = [];

    /**
     * Register a widget class.
     *
     * @param ...$class
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

    public function getWidgets()
    {
        return $this->widgets;
    }

    public function getWidget($slug)
    {
        return $this->widgets[$slug] ?? false;
    }
}