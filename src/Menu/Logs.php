<?php

namespace Sebastienheyd\Boilerplate\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder as Builder;

class Logs
{
    public function make(Builder $menu)
    {
        $menu->add(__('boilerplate::logs.menu.category'), ['permission' => 'logs', 'icon' => 'list'])
            ->id('logs')
            ->order(1100);

        $menu->addTo('logs', __('boilerplate::logs.menu.stats'), [
            'route'      => 'boilerplate.logs.dashboard',
            'active'     => 'boilerplate.logs.dashboard',
            'permission' => 'logs',
        ])->order(1110);

        $menu->addTo('logs', __('boilerplate::logs.menu.reports'), [
            'route'      => 'boilerplate.logs.list',
            'active'     => 'boilerplate.logs.list,boilerplate.logs.show,boilerplate.logs.filter',
            'permission' => 'logs',
        ])->order(1120);
    }
}
