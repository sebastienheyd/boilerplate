<?php

namespace Sebastienheyd\Boilerplate\Navbar;

use Illuminate\View\View;

class NavbarItemsRepository
{
    /**
     * Register navbar items to display.
     *
     * @param  string|array  $item
     * @param  string  $side
     * @return $this
     */
    public function registerItem($item, $side = 'left')
    {
        if (! in_array($side, ['left', 'right'])) {
            throw new \InvalidArgumentException('Side is not allowed');
        }

        if (! is_string($item) && ! is_array($item)) {
            throw new \InvalidArgumentException('Item is not an array or a string');
        }

        $items = config('boilerplate.theme.navbar.'.$side, []);

        if (is_string($item)) {
            $item = [view($item)];
        }

        $items = array_merge($items, $item);
        $views = [];

        foreach ($items as $view) {
            if (is_string($view)) {
                $view = view($view);
            }

            if (! ($view instanceof View)) {
                throw new \InvalidArgumentException('Registered item is not an instance of View');
            }

            $views[] = $view;
        }

        config(['boilerplate.theme.navbar.'.$side => array_unique($views)]);

        return $this;
    }

    /**
     * Get navbar items views for the given side.
     *
     * @param  string  $side
     * @return array
     */
    public function getItems($side = 'left')
    {
        return array_unique(config('boilerplate.theme.navbar.'.$side, []));
    }
}
