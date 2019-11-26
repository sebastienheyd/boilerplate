<?php

namespace Sebastienheyd\Boilerplate\Menu;

class MenuItemsRepository
{
    protected $items = [];

    /**
     * Register menu items to display in the main menu
     *
     * @param string|array $menuitem
     * @return $this
     */
    public function registerMenuItem($menuitem)
    {
        if (is_array($menuitem)) {
            $this->items = array_merge($this->items, $menuitem);
        } elseif (is_string($menuitem)) {
            $this->items[] = $menuitem;
        }
        return $this;
    }

    /**
     * Get menu items classes
     *
     * @return array
     */
    public function getMenuItems()
    {
        return array_unique($this->items);
    }
}
