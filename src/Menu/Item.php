<?php

namespace Sebastienheyd\Boilerplate\Menu;

use Illuminate\Support\Arr;
use Lavary\Menu\Item as LavaryMenuItem;

class Item extends LavaryMenuItem
{
    public function __construct($builder, $id, $title, $options)
    {
        Arr::forget($options, ['role', 'permission', 'icon', 'active']);
        $options['class'] = 'nav-item';
        parent::__construct($builder, $id, $title, $options);
    }

    /**
     * Set the item icon using font-awesome.
     *
     * @param  string  $icon
     * @param  string  $type
     * @return self
     */
    public function icon($icon, $type = 'fas')
    {
        if (preg_match('#^https?|\.(png|jpg|gif|svg)$#', $icon)) {
            $img = '<img src="%s" class="img-fluid" style="max-height: 17px" />';
            $this->prepend(sprintf('<div class="nav-icon d-inline-block text-sm">'.$img.'</div>', $icon));

            return $this;
        }

        if (preg_match('#^(fa[bsr])\s#', $icon, $m)) {
            $type = $m[1];
        }

        if (preg_match('#fa-(.*)$#', $icon, $m)) {
            $icon = $m[1];
        }

        $this->prepend(sprintf('<i class="nav-icon %s fa-%s"></i>', $type, $icon));

        return $this;
    }

    /**
     * Set the item order.
     *
     * @param $order
     * @return self
     */
    public function order($order)
    {
        $this->data('order', $order);

        return $this;
    }

    /**
     * Add a class to the current link.
     *
     * @param  string  $class
     * @return $this
     */
    public function addLinkClass($class)
    {
        $classes = [];
        if (! empty($this->link->attributes['class'])) {
            $classes = explode(' ', $this->link->attributes['class']);
        }

        $classes[] = $class;
        $this->link->attr(['class' => implode(' ', array_unique($classes))]);

        return $this;
    }

    /**
     * Make the item active.
     *
     * @param  string|array  $routes
     * @return self
     */
    public function activeIfRoute($routes)
    {
        if (is_string($routes)) {
            $routes = explode(',', $routes);
        }

        foreach ($routes as $pattern) {
            if (if_route_pattern($pattern)) {
                $this->addLinkClass('active elevation-'.config('boilerplate.theme.sidebar.links.shadow'));

                if ($this->hasParent()) {
                    $this->parent()->attr(['class' => 'nav-item has-treeview menu-open'])->addLinkClass('active');
                }

                $this->isActive = true;

                return $this;
            }
        }

        return $this;
    }

    /**
     * Creates a sub Item.
     *
     * @param  string  $title
     * @param  string|array  $options
     * @return \Lavary\Menu\Item
     */
    public function add($title, $options = [])
    {
        $options['parent'] = $this->id;
        $this->append('<i class="fa fa-angle-left right"></i>');

        return $this->builder->add($title, $options);
    }
}
