<?php

namespace Sebastienheyd\Boilerplate\Dashboard;

class DashboardWidgetsRepository
{
    protected $widgets = [];

    public function __construct()
    {
        $this->getProviders();
    }

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

    private function getProviders()
    {
        if (! is_dir(app_path('Dashboard'))) {
            return;
        }

        $classes = glob(app_path('Dashboard').'/*.php');

        if (empty($classes)) {
            return;
        }

        foreach ($classes as $class) {
            $this->registerWidget('\\App\\Dashboard\\'.preg_replace('#\.php$#i', '', basename($class)));
        }
    }
}