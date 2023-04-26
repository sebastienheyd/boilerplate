<?php

namespace Sebastienheyd\Boilerplate\Navbar;

use Illuminate\View\View;

class NavbarItemsRepository
{
    /**
     * Register navbar items to display.
     *
     * @param  string|array|View  $item
     * @param  string  $side
     * @return $this
     */
    public function registerItem($item, $side = 'left')
    {
        if (! in_array($side, ['left', 'right'])) {
            throw new \InvalidArgumentException('Side is not allowed');
        }

        if (is_array($item)) {
            foreach ($item as $view) {
                $this->registerItem($view, $side);
            }

            return $this;
        }

        $items = array_merge(config('boilerplate.theme.navbar.'.$side, []), [$item]);
        config(['boilerplate.theme.navbar.'.$side => array_unique($items)]);

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
        $items = array_unique(config('boilerplate.theme.navbar.'.$side, []));

        foreach ($items as $k => $item) {
            $items[$k] = view($item);
        }

        return $items;
    }
}
