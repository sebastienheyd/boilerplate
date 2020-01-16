<?php

namespace Sebastienheyd\Boilerplate\Navbar;

class NavbarItemsRepository
{
    /**
     * Register navbar items to display.
     *
     * @param string|array $item
     * @param string       $side
     *
     * @return $this
     */
    public function registerItem($item, $side = 'left')
    {
        $items = config('boilerplate.theme.navbar.'.$side, []);

        if (is_array($item)) {
            $items = array_merge($items, $item);
        } elseif (is_string($item)) {
            $items[] = $item;
        }

        config(['boilerplate.theme.navbar.'.$side => array_unique($items)]);

        return $this;
    }

    /**
     * Get navbar items views for the given side.
     *
     * @param string $side
     *
     * @return array
     */
    public function getItems($side = 'left')
    {
        return array_unique(config('boilerplate.theme.navbar.'.$side, []));
    }
}
