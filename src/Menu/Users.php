<?php

namespace Sebastienheyd\Boilerplate\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder as Builder;

class Users
{
    public function make(Builder $menu)
    {
        $menu->add(__('boilerplate::layout.access'), ['icon' => 'users'])
            ->id('access')
            ->order(1000);

        $menu->addTo('access', __('boilerplate::users.list.title'), [
            'route'      => 'boilerplate.users.index',
            'active'     => 'boilerplate.users.index,boilerplate.users.edit',
            'permission' => 'users_crud',
        ]);

        $menu->addTo('access', __('boilerplate::users.create.title'), [
            'route'      => 'boilerplate.users.create',
            'permission' => 'users_crud',
        ]);

        $menu->addTo('access', __('boilerplate::layout.role_management'), [
            'route'      => 'boilerplate.roles.index',
            'active'     => 'boilerplate.roles.*',
            'permission' => 'roles_crud',
        ]);

        $menu->addTo('access', __('boilerplate::users.profile.title'), [
            'route' => 'boilerplate.user.profile'
        ]);
    }
}
