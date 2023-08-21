<?php

namespace Sebastienheyd\Boilerplate\Dashboard;

abstract class Widget
{
    protected $slug;
    protected $label;
    protected $description;
    protected $permission;
    protected $size = 'md';
    protected $width;
    protected $view;
    protected $editView;
    protected $parameters = [];
    private $settings = [];
    private $values = [];

    abstract public function make();

    protected function assign($name, $value = null)
    {
        if (is_string($name)) {
            if (empty($value)) {
                return $this;
            }

            $name = [$name => $value];
        }

        $this->values = array_merge($this->values, $name);

        return $this;
    }

    public function set($name, $value = null)
    {
        if (is_string($name)) {
            if (empty($value)) {
                return $this;
            }

            $name = [$name => $value];
        }

        $this->settings = array_merge($this->settings, $name);

        return $this;
    }

    public function getSettings()
    {
        foreach (auth()->user()->setting('dashboard', config('boilerplate.dashboard.widgets')) as $widgetParameters) {
            [$widgetSlug, $settings] = [array_key_first($widgetParameters), $widgetParameters[array_key_first($widgetParameters)]];
            if ($widgetSlug === $this->slug) {
                return array_merge($settings, $this->settings);
            }
        }

        return $this->settings;
    }

    public function render()
    {
        $parameters = array_merge($this->parameters, $this->settings, $this->values);
        return view($this->view, $parameters)->render();
    }

    public function getEditView()
    {
        return $this->editView ?? false;
    }

    public function renderEdit($values = [])
    {
        $parameters = array_merge($this->parameters, $values);
        return view($this->editView, $parameters)->render();
    }

    public function isAuthorized()
    {
        return empty($this->permission) || Auth::user()->ability('admin', $this->permission);
    }

    public function isEditable()
    {
        return ! empty($this->parameters) && ! empty($this->editView);
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function __get($prop)
    {
        if ($prop === 'label' || $prop === 'description') {
            return __($this->{$prop}) ?: static::class.' → '.$prop;
        }

        if ($prop === 'width' && empty($this->width)) {
            $sizes = [
                'xxs' => ['sm' => 4, 'md' => 4, 'xl' => 2, 'xxl' => 2],
                'xs' => ['sm' => 6, 'md' => 6, 'xl' => 4, 'xxl' => 3],
                'sm' => ['sm' => 12, 'md' => 6, 'xl' => 6, 'xxl' => 4],
                'md' => ['sm' => 12, 'md' => 6, 'xl' => 6, 'xxl' => 6],
                'xl' => ['sm' => 12, 'md' => 12, 'xl' => 8, 'xxl' => 8],
                'xxl' => ['sm' => 12, 'md' => 12, 'xl' => 12, 'xxl' => 12],
            ];

            return $sizes[$this->size] ?? ['sm' => 6, 'md' => 6, 'xl' => 4, 'xxl' => 3];
        }

        if (property_exists($this, $prop)) {
            return $this->{$prop};
        }

        return null;
    }
}