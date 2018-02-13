<?php

namespace Sebastienheyd\Boilerplate\ViewComposers;

use Illuminate\View\View;
use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\Menu;

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
        $menu = new Menu();
        $menu = $menu->make('AdminMenu', function(Builder $menu) {

            $menu->raw(__('boilerplate::layout.mainmenu'), [ 'class' => 'header text-uppercase' ])->order(0);

            $menu->add(__('boilerplate::layout.dashboard'), [ 'route' => 'boilerplate.home', 'icon' => 'home' ])
                 ->id('home')
                 ->order(1);

            $providers = config('boilerplate.menu.providers');

            foreach ($providers as $provider) {
                $class = new $provider;
                $class->make($menu);
            }
        });

        $view->with('menu', $menu->sortBy('order')->asUl([
            'class' => 'sidebar-menu',
            'data-widget' => "tree"
        ], [ 'class' => 'treeview-menu' ]));
    }
}