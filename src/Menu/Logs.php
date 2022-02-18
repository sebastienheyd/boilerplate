<?php

namespace Sebastienheyd\Boilerplate\Menu;

class Logs
{
    public function make(Builder $menu)
    {
        $item = $menu->add('boilerplate::logs.menu.category', [
            'permission' => 'logs',
            'icon' => 'list',
            'order' => 1100,
        ]);

        $item->add('boilerplate::logs.menu.stats', [
            'route' => 'boilerplate.logs.dashboard',
        ]);

        $item->add('boilerplate::logs.menu.reports', [
            'route' => 'boilerplate.logs.list',
            'active' => 'boilerplate.logs.list,boilerplate.logs.show,boilerplate.logs.filter',
        ]);
    }
}
