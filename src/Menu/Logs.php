<?php namespace Sebastienheyd\Boilerplate\Menu;

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
                'permission' => 'logs'])
            ->order(1110)
            ->activeIfRoute('boilerplate.logs.dashboard');

        $menu->addTo('logs', __('boilerplate::logs.menu.reports'), [
                'route'      => 'boilerplate.logs.list',
                'permission' => 'logs'])
            ->order(1120)
            ->activeIfRoute(['boilerplate.logs.list', 'boilerplate.logs.show', 'boilerplate.logs.filter']);
    }
}
