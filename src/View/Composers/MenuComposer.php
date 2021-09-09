<?php

namespace Sebastienheyd\Boilerplate\View\Composers;

use Illuminate\View\View;
use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\Menu;

class MenuComposer
{
    /**
     * Called when view layout/mainsidebar.blade.php is called.
     * This is defined in BoilerPlateServiceProvider.
     *
     * @param  View  $view
     */
    public function compose(View $view)
    {
        $menu = new Menu();
        $menu = $menu->make('AdminMenu', function (Builder $menu) {
            $menu->add(__('boilerplate::layout.dashboard'), ['route' => 'boilerplate.dashboard', 'icon' => 'home'])
                ->activeIfRoute('boilerplate.dashboard')
                ->id('home')
                ->order(0);

            $providers = $this->getProviders();

            foreach ($providers as $provider) {
                $class = new $provider();
                $class->make($menu);
            }
        });

        $compact = config('boilerplate.theme.sidebar.compact') === true ? ' nav-compact' : '';

        $view->with('menu', $menu->sortBy('order')->asUl([
            'class'          => 'nav nav-pills nav-sidebar flex-column nav-child-indent'.$compact,
            'data-widget'    => 'treeview',
            'data-accordion' => 'false',
            'role'           => 'menu',
        ], ['class' => 'nav nav-treeview']));
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

            if (! empty($classes)) {
                foreach ($classes as $class) {
                    $providers[] = '\\App\\Menu\\'.preg_replace('#\.php$#i', '', basename($class));
                }
            }
        }

        return $providers;
    }
}
