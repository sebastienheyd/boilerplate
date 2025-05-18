<?php

namespace Sebastienheyd\Boilerplate\Menu;

class Logs implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $menu->add('boilerplate::logs.menu.category', [
            'route'      => 'boilerplate.logs.list',
            'permission' => 'logs',
            'icon'       => 'list',
            'order'      => 1100,
            'active'     => 'boilerplate.logs.list,boilerplate.logs.show',
        ]);
    }
}
