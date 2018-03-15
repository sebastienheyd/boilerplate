<?php

namespace Sebastienheyd\Boilerplate;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;

class BoilerplateServiceProvider extends ServiceProvider
{
    protected $defer = false;
    protected $loader;
    protected $router;

    /**
     * Create a new boilerplate service provider instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->loader = AliasLoader::getInstance();
        $this->router = app('router');
        return parent::__construct($app);
    }

    /**
     * Bootstrap the boilerplate services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish all files when calling php artisan vendor:publish
        $this->publishes([ __DIR__.'/config'         => config_path()], 'config');
        $this->publishes([ __DIR__.'/routes'         => base_path('routes/')], 'routes');
        $this->publishes([ __DIR__.'/resources'      => base_path('resources/')], 'resources');
        $this->publishes([ __DIR__.'/public'         => base_path('public/')], 'public');
        $this->publishes([ __DIR__.'/Models'         => app_path('Models')], 'models');
        $this->publishes([ __DIR__.'/Notifications'  => app_path('Notifications')], 'notifications');
        $this->publishes([ __DIR__.'/webpack.mix.js' => base_path('webpack.mix.js')], 'webpack');

        // If routes file has been published, load routes from the published file
        if (is_file(base_path('routes/boilerplate.php'))) {
            $this->loadRoutesFrom(base_path('routes/boilerplate.php'));
        } else {
            $this->loadRoutesFrom(__DIR__.'/routes/boilerplate.php');
        }

        // Load migrations, views and translations from current directory
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views/vendor/boilerplate', 'boilerplate');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang/vendor/boilerplate', 'boilerplate');

        // Loading dynamic menu when calling the view
        View::composer('boilerplate::layout.mainsidebar', 'Sebastienheyd\Boilerplate\ViewComposers\MenuComposer');

        // For datatables locales
        View::composer('boilerplate::load.datatables', 'Sebastienheyd\Boilerplate\ViewComposers\DatatablesComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Get config
        $this->mergeConfigFrom(__DIR__.'/config/boilerplate/app.php', 'boilerplate.app');
        $this->mergeConfigFrom(__DIR__.'/config/boilerplate/laratrust.php', 'boilerplate.laratrust');
        $this->mergeConfigFrom(__DIR__.'/config/boilerplate/auth.php', 'boilerplate.auth');
        $this->mergeConfigFrom(__DIR__.'/config/boilerplate/menu.php', 'boilerplate.menu');

        // Overriding Laravel config
        config([
            'auth.providers.users.driver' => config('boilerplate.auth.providers.users.driver', 'eloquent'),
            'auth.providers.users.model' => config('boilerplate.auth.providers.users.model', 'App\User'),
            'auth.providers.users.table' => config('boilerplate.auth.providers.users.table', 'users'),
            'app.log' => 'daily',
            'log-viewer.route.enabled' => false,
            'log-viewer.menu.filter-route'  => 'logs.filter'
        ]);

        $this->router->aliasMiddleware('boilerplatelocale', Middleware\BoilerplateLocale::class);

        // Loading packages
        $this->_registerLaratrust();
        $this->_registerMenu();
    }

    /**
     * Register package lavary/laravel-menu
     */
    private function _registerMenu()
    {
        $this->app->register(\Lavary\Menu\ServiceProvider::class);
        $this->loader->alias('Menu', \Lavary\Menu\Facade::class);
    }

    /**
     * Register package lavary/laravel-menu
     */
    private function _registerLaratrust()
    {
        $this->app->register(\Laratrust\LaratrustServiceProvider::class);
        $this->loader->alias('Laratrust', \Laratrust\LaratrustFacade::class);

        // Overriding config
        config([
            'laratrust.user_models.users' => config('boilerplate.laratrust.user', 'App\User'),
            'laratrust.role' => config('boilerplate.laratrust.role', 'App\Role'),
            'laratrust.permission' => config('boilerplate.laratrust.permission', 'App\Permission'),
        ]);

        // Registering middlewares
        $this->router->aliasMiddleware('role', \Laratrust\Middleware\LaratrustRole::class);
        $this->router->aliasMiddleware('permission', \Laratrust\Middleware\LaratrustPermission::class);
        $this->router->aliasMiddleware('ability', \Laratrust\Middleware\LaratrustAbility::class);
    }
}
