<?php

namespace Sebastienheyd\Boilerplate\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder as Builder;

class Users
{
    public function make(Builder $menu)
    {
        $menu->add(__('boilerplate::layout.access'), ['permission' => 'users_crud,roles_crud', 'icon' => 'users'])
            ->id('access')
            ->order(1000);

        $menu->addTo('access', __('boilerplate::layout.user_management'), ['route' => 'boilerplate.users.index', 'permission' => 'users_crud'])
            ->order(1010)
            ->activeIfRoute('boilerplate.users.*');

        $menu->addTo('access', __('boilerplate::layout.role_management'), ['route' => 'boilerplate.roles.index', 'permission' => 'roles_crud'])
            ->order(1020)
            ->activeIfRoute('boilerplate.roles.*');
    }
}