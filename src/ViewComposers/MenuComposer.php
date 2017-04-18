<?php

namespace Sebastienheyd\Boilerplate\ViewComposers;

use Illuminate\View\View;
use Lavary\Menu\Builder;
use Menu;
use Auth;

class MenuComposer
{
    /**
     * Called when view layout/mainsidebar.blade.php is called.
     * This is defined in BoilerPlateServiceProvider.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $menu = Menu::make('AdminMenu', function(Builder $menu) {

            $menu->raw(__('boilerplate::layout.mainmenu'), ['class' => 'header text-uppercase'])->data('order', 0);

            $menu->add(trans('boilerplate::layout.dashboard'), ['route' => 'boilerplate.home'])
                ->data('order', 1)
                ->prepend('<span class="fa fa-home"></span> ');

            $providers = config('boilerplate.menu.providers');

            foreach($providers as $provider) {
                $class = new $provider;
                $class->make($menu);
            }

        });

        $view->with('menu', $menu->sortBy('order')->asUl(['class' => 'sidebar-menu'], ['class' => 'treeview-menu']));
    }

    /**
     * Called as a menu provider, will build access management menu items
     *
     * @see config file menu.php
     *
     * @param Builder $menu
     */
    public function make(Builder $menu)
    {
        $currentUser = Auth::user();

        if($currentUser->ability('admin', ['users_crud', 'roles_crud'])) {
            $menu->add(__('boilerplate::layout.access'), ['url' => '#', 'class' => 'treeview'])
                ->id('access')
                ->data('order', 1000)
                ->prepend('<i class="fa fa-users"></i>')
                ->append('<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>');

            if(if_route_pattern(['roles.*', 'users.*'])) $menu->find('access')->active();
        }

        if($currentUser->ability('admin', ['users_crud'])) {
            $menu->find('access')
                ->add(__('boilerplate::layout.user_management'), ['route' => 'users.index'])
                ->id('users')
                ->data('order', 1010)
                ->prepend('<span class="fa fa-circle-o"></span> ');

            if (if_route_pattern('users.*')) $menu->find('users')->active();
        }

        if($currentUser->ability('admin', ['roles_crud'])) {
            $menu->find('access')
                ->add(__('boilerplate::layout.role_management'), ['route' => 'roles.index'])
                ->id('roles')
                ->data('order', 1020)
                ->prepend('<span class="fa fa-circle-o"></span> ');

            if (if_route_pattern('roles.*')) $menu->find('roles')->active();
        }

        if($currentUser->ability('admin', ['logs'])) {
            $menu->add(__('boilerplate::logs.menu.category'), ['url' => '#', 'class' => 'treeview'])
                ->id('logs')
                ->data('order', 1100)
                ->prepend('<i class="fa fa-list"></i>')
                ->append('<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>');

            if(if_route_pattern(['logs.*'])) $menu->find('logs')->active();

            $menu->find('logs')
                ->add(__('boilerplate::logs.menu.stats'), ['route' => 'logs.dashboard'])
                ->id('logs_dashboard')
                ->data('order', 1110)
                ->prepend('<span class="fa fa-circle-o"></span> ');

            if (if_route('logs.dashboard')) $menu->find('logs')->active();

            $menu->find('logs')
                ->add(__('boilerplate::logs.menu.reports'), ['route' => 'logs.list'])
                ->id('logs_list')
                ->data('order', 1120)
                ->prepend('<span class="fa fa-circle-o"></span> ');

            if (if_route(['logs.list', 'logs.show', 'logs.filter'])) $menu->find('logs_list')->active();
        }
    }
}