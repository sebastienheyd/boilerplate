<?php namespace Sebastienheyd\Boilerplate\Menu;

use Lavary\Menu\Item as LavaryMenuItem;

class Item extends LavaryMenuItem
{
    /**
     * Set the item icon using font-awesome
     *
     * @param $icon
     *
     * @return self
     */
    public function icon($icon)
    {
        $this->prepend(sprintf('<i class="fa fa-%s"></i>', $icon));
        return $this;
    }

    /**
     * Set the item order
     *
     * @param $order
     *
     * @return self
     */
    public function order($order)
    {
        $this->data('order', $order);
        return $this;
    }

    /**
     * Make the item active
     *
     * @param string|array $routes
     *
     * @return self
     */
    public function activeIfRoute($routes = null)
    {
        if (!empty($routes)) {
            if (is_string($routes)) {
                $routes = [$routes];
            }

            foreach ($routes as $pattern) {
                if (if_route_pattern($pattern)) {
                    $this->activate();

                    if (strstr($this->title, 'circle-o')) {
                        $this->title = str_replace('fa-circle-o', 'fa-dot-circle-o', $this->title);
                    }

                    return $this;
                }
            }

            return $this;
        }

        $activeClass = $this->builder->conf('active_class');
        $this->attributes['class'] = Builder::formatGroupClass(['class' => $activeClass], $this->attributes);
        $this->isActive = true;

        if (strstr($this->title, 'circle-o')) {
            $this->title = str_replace('fa-circle-o', 'fa-dot-circle-o', $this->title);
        }

        return $this;
    }
}
