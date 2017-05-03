<?php

namespace Sebastienheyd\Boilerplate\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder as Builder;

class Logs
{
    public function make(Builder $menu)
    {
        $menu->add(__('boilerplate::logs.menu.category'), [ 'role' => 'logs', 'icon' => 'list' ])
            ->id('logs')
            ->order(1100);

        $menu->addTo('logs', __('boilerplate::logs.menu.stats'), [ 'route' => 'logs.dashboard', 'role' => 'logs' ])
            ->order(1110)
            ->activeIfRoute('logs.dashboard');

        $menu->addTo('logs', __('boilerplate::logs.menu.reports'), [ 'route' => 'logs.list', 'role' => 'logs' ])
            ->order(1120)
            ->activeIfRoute([ 'logs.list', 'logs.show', 'logs.filter' ]);
    }
}