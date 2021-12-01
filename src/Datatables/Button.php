<?php

namespace Sebastienheyd\Boilerplate\Datatables;

class Button
{
    protected $class = '';
    protected $color = 'default';
    protected $href = '#';
    protected $icon = '';
    protected $label = '';
    protected $attributes = [];

    /**
     * Instanciate a new button.
     *
     * @param  string  $label
     */
    public function __construct(string $label)
    {
        $this->label = $label;
    }

    /**
     * Starts creating a new button.
     *
     * @param  string  $label
     * @return $this
     */
    public static function add(string $label = ''): self
    {
        return new static($label);
    }

    /**
     * Returns an edit button.
     *
     * @param  string  $route
     * @param  mixed  $args
     * @return string
     */
    public static function show(string $route, $args = []): string
    {
        return self::add()->attributes(['data-action' => 'dt-show-element'])->route($route, $args)->icon('eye')->make();
    }

    /**
     * Returns an edit button.
     *
     * @param  string  $route
     * @param  mixed  $args
     * @return string
     */
    public static function edit(string $route, $args = []): string
    {
        return self::add()->attributes(['data-action' => 'dt-edit-element'])->route($route, $args)->color('primary')->icon('pencil-alt')->make();
    }

    /**
     * Returns a delete button.
     *
     * @param  string  $route
     * @param  mixed  $args
     * @return string
     */
    public static function delete(string $route, $args = []): string
    {
        return self::add()
            ->route($route, $args)
            ->attributes(['data-action' => 'dt-delete-element'])
            ->color('danger')
            ->icon('trash')
            ->make();
    }

    /**
     * Assign attributes to the button.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function attributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Adds a FontAwesome icon.
     *
     * @param  string  $icon
     * @param  string  $style
     * @return $this
     *
     * @link https://fontawesome.com/v5.15/icons
     */
    public function icon(string $icon, string $style = 's'): self
    {
        if (! in_array($style, ['s', 'r', 'l', 'd', 'b'])) {
            $style = 's';
        }

        $icon = preg_replace('#^fa-#', '', $icon);

        $this->icon = sprintf('<i class="fa%s fa-fw fa-%s"></i>', $style, $icon);

        return $this;
    }

    /**
     * Sets a Bootstrap 4 color to the button.
     *
     * @param  string  $color
     * @return $this
     *
     * @link https://getbootstrap.com/docs/4.0/utilities/colors/
     */
    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Adds a class to the button.
     *
     * @param  string  $class
     * @return $this
     */
    public function class(string $class): self
    {
        $this->class = ' '.$class;

        return $this;
    }

    /**
     * Sets the route to use.
     *
     * @param  string  $route
     * @param  array|string  $args
     * @return $this
     */
    public function route(string $route, $args = []): self
    {
        return $this->link(route($route, $args, false));
    }

    /**
     * Sets a link href to use.
     *
     * @param  string  $href
     * @return $this
     */
    public function link(string $href): self
    {
        $this->href = $href;

        return $this;
    }

    /**
     * Renders the button.
     *
     * @return string
     */
    public function make(): string
    {
        $str = '<a href="%s" class="btn btn-sm btn-%s ml-1%s" %s>%s%s</a>';

        if (! empty($this->label) && ! empty($this->icon)) {
            $this->label = $this->label.' ';
        }

        $attributes = join(' ', array_map(function ($k) {
            if (is_bool($this->attributes[$k]) && $this->attributes[$k] === true) {
                return $this->attributes[$k] ? $k : '';
            }

            return sprintf('%s="%s"', $k, $this->attributes[$k]);
        }, array_keys($this->attributes)));

        return sprintf($str, $this->href, $this->color, $this->class, $attributes, $this->label, $this->icon);
    }
}
