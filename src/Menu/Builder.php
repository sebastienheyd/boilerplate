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
        $title = __($title);
        $title = sprintf('<p>%s</p>', $title);
        $id = $options['id'] ?? $this->id();

        $item = new Item($this, $id, $title, $options);
        $item->addLinkClass('nav-link');

        if (! empty($options['active'])) {
            $item->activeIfRoute($options['active']);
        } elseif (! empty($options['route'])) {
            $item->activeIfRoute($options['route']);
        }

        if (! empty($options['icon'])) {
            $item->icon($options['icon']);
        } elseif ($item->hasParent()) {
            $item->icon($item->isActive ? 'dot-circle ' : 'circle', 'far');
        } else {
            $item->icon('cube');
        }

        if (! empty($options['order'])) {
            $item->order($options['order']);
        }

        if (! empty($options['role']) || ! empty($options['permission'])) {
            $ability = ['admin'];
            if (! empty($options['role'])) {
                $ability = array_merge($ability, explode(',', $options['role']));
            }

            $permission = [];
            if (! empty($options['permission'])) {
                $permission = explode(',', $options['permission']);
            }

            if (empty($permission)) {
                if (Auth::user()->hasRole($ability)) {
                    $this->items->push($item);
                }
            } else {
                if (Auth::user()->ability($ability, $permission)) {
                    $this->items->push($item);
                }
            }
        } else {
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
                $parent->append('<i class="fa fa-angle-left right"></i>');
                $this->root[$parent->id] = true;
            }

            $item = $parent->add($title, $options);
        } else {
            $item = $this->add($title, $options);
        }

        return $item;
    }
}
