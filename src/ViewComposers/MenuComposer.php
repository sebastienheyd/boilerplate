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
        $menu = $menu->make('AdminMenu', function (Builder $menu) {
            $menu->raw(__('boilerplate::layout.mainmenu'), ['class' => 'header text-uppercase'])->order(0);

            $menu->add(__('boilerplate::layout.dashboard'), ['route' => 'boilerplate.dashboard', 'icon' => 'home'])
                ->id('home')
                ->order(1);

            $providers = $this->getProviders();

            foreach ($providers as $provider) {
                $class = new $provider();
                $class->make($menu);
            }
        });

        $view->with('menu', $menu->sortBy('order')->asUl([
            'class'       => 'sidebar-menu',
            'data-widget' => 'tree',
        ], ['class' => 'treeview-menu']));
    }

    /**
     * Get menu items providers.
     *
     * @return array
     */
    private function getProviders()
    {
        $providers = app('boilerplate.menu.items')->getMenuItems();

        if (is_dir(app_path('Menu'))) {
            $classes = glob(app_path('Menu').'/*.php');

            if (!empty($classes)) {
                foreach ($classes as $class) {
                    $providers[] = '\\App\\Menu\\'.preg_replace('#\.php$#i', '', basename($class));
                }
            }
        }

        return $providers;
    }
}
