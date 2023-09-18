<?php

namespace Sebastienheyd\Boilerplate\Menu;

use Auth;
use Illuminate\Support\Collection;
use Lavary\Menu\Builder as LavaryMenuBuilder;

/**
 * Class Builder.
 *
 * @property Collection $items;
 */
class Builder extends LavaryMenuBuilder
{
    private $root = [];

    /**
     * Adds an item to the menu.
     *
     * @param  string  $title
     * @param  array  $options
     * @return Item
     */
    public function add($title, $options = [])
    {
        $title = sprintf('<p>%s</p>', __($title));
        $id = $options['id'] ?? $this->id();

        $item = new Item($this, $id, $title, $options);
        $item->addLinkClass('nav-link');
        $item->activeIfRoute($options['active'] ?? $options['route'] ?? []);
        $item->order($options['order'] ?? null);

        $item->icon('stop');
        if (! empty($options['icon'])) {
            $item->icon($options['icon']);
        } elseif ($item->hasParent()) {
            $item->icon($item->isActive ? 'dot-circle ' : 'circle', 'far');
        }

        $roles = array_unique(!empty($options['role']) ? array_merge(['admin'], explode(',', $options['role'])) : ['admin']);
        $permissions = array_unique(!empty($options['permission']) ? explode(',', $options['permission']) : ['backend_access']);

        if (Auth::user()->hasRole($roles) || Auth::user()->isAbleTo($permissions)) {
            $this->items->push($item);
        }

        return $item;
    }

    /**
     * Add an item to a existing menu item as a submenu item.
     *
     * @param  string  $id  Id of the menu item to attach to
     * @param  string  $title  Title of the sub item
     * @param  array  $options
     * @return Item
     */
    public function addTo($id, $title, $options = [])
    {
        $parent = $this->whereId($id)->first();

        if (isset($parent)) {
            if (! isset($this->root[$parent->id])) {
                $parent->attr(['url' => '#', 'class' => 'nav-item has-treeview']);
                $parent->hasSubItems = true;
                $this->root[$parent->id] = true;
            }

            $item = $parent->add($title, $options);
        } else {
            $item = new Item($this, $id, $title, $options);
        }

        return $item;
    }

    public function render($type = 'ul', $parent = null, $children_attributes = [], $item_attributes = [], $item_after_calback = null, $item_after_calback_params = [])
    {
        foreach ($this->whereParent($parent) as $item) {
            if ($item->getIcon(true) === 'circle') {
                $item->icon($item->isActive ? 'dot-circle ' : 'circle', 'far');
            }

            if (! empty($item->getIcon(true))) {
                $item->prepend($item->getIcon());
            }

            if ($item->hasSubItems) {
                $item->append('<i class="fa fa-angle-left right"></i>');
            }
        }

        return parent::render($type, $parent, $children_attributes, $item_attributes, $item_after_calback, $item_after_calback_params);
    }
}
