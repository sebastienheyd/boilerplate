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

            $this->widgets[] = $c;
        }

        return $this;
    }

    public function getWidgets()
    {
        if (empty($this->widgets)) {
            return [];
        }

        $widgets = [];

        foreach ($this->widgets as $widget) {
            $widgets[] = new $widget;
        }

        return $widgets;
    }
}