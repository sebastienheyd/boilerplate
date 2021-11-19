<?php

namespace Sebastienheyd\Boilerplate\Datatables;

class Button
{
    protected $class = '';
    protected $color = 'default';
    protected $href = '#';
    protected $icon = '';
    protected $label = '';

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
     * @return Button
     */
    public static function add(string $label = ''): Button
    {
        return new static($label);
    }

    /**
     * Adds a FontAwesome icon.
     *
     * @link https://fontawesome.com/v5.15/icons
     *
     * @param  string  $icon
     * @param  string  $style
     * @return $this
     */
    public function icon(string $icon, string $style = 's'): Button
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
     * @link https://getbootstrap.com/docs/4.0/utilities/colors/
     *
     * @param  string  $color
     * @return $this
     */
    public function color(string $color): Button
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
    public function class(string $class): Button
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
    public function route(string $route, $args = []): Button
    {
        return $this->link(route($route, $args, false));
    }

    /**
     * Sets a link href to use.
     *
     * @param  string  $href
     * @return $this
     */
    public function link(string $href): Button
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
        $str = '<a href="%s" class="btn btn-sm btn-%s ml-1%s">%s%s</a>';

        if (! empty($this->label) && ! empty($this->icon)) {
            $this->label = $this->label.' ';
        }

        return sprintf($str, $this->href, $this->color, $this->class, $this->label, $this->icon);
    }
}
