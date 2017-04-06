<?php

namespace Sebastienheyd\Boilerplate;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class BoilerplateServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config'         => config_path(),
            __DIR__ . '/routes'         => base_path('routes/'),
            __DIR__ . '/resources'      => base_path('resources/'),
            __DIR__ . '/public'         => base_path('public/'),
            __DIR__ . '/Models'         => app_path('Models'),
            __DIR__ . '/Notifications'  => app_path('Notifications'),
            __DIR__ . '/webpack.mix.js' => base_path('webpack.mix.js'),
        ]);

        if(is_file(base_path('routes/boilerplate.php'))) {
            $this->loadRoutesFrom(base_path('routes/boilerplate.php'));
        } else {
            $this->loadRoutesFrom(__DIR__ . '/routes/boilerplate.php');
        }

        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views/vendor/boilerplate', 'boilerplate');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang/vendor/boilerplate', 'boilerplate');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/boilerplate/app.php', 'boilerplate.app');
        $this->mergeConfigFrom(__DIR__.'/config/boilerplate/laratrust.php', 'boilerplate.laratrust');
        $this->mergeConfigFrom(__DIR__.'/config/boilerplate/auth.php', 'boilerplate.auth');
        $this->mergeConfigFrom(__DIR__.'/config/boilerplate/cache.php', 'boilerplate.cache');

        config([
            'auth.providers.users.driver' => config('boilerplate.auth.providers.users.driver', 'eloquent'),
            'auth.providers.users.model' => config('boilerplate.auth.providers.users.model', 'App\User'),
            'auth.providers.users.table' => config('boilerplate.auth.providers.users.table', 'users'),
            'cache.default' => config('boilerplate.cache.default', 'array'),
        ]);

        $this->_registerLaratrust();
        $this->_registerLaravelCollective();
        $this->_registerActive();
        $this->_registerDatatables();
        $this->_registerDate();
    }

    private function _registerDate()
    {
        $this->app->register(\Jenssegers\Date\DateServiceProvider::class);
        $loader = AliasLoader::getInstance();
        $loader->alias('Date', \Jenssegers\Date\Date::class);
    }

    private function _registerDatatables()
    {
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
    }

    private function _registerLaravelCollective()
    {
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('Html', \Collective\Html\HtmlFacade::class);
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function _registerLaratrust()
    {
        $this->app->register(\Laratrust\LaratrustServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Laratrust', \Laratrust\LaratrustFacade::class);

        config([
            'laratrust.role' => config('boilerplate.laratrust.role', 'App\Role'),
            'laratrust.permission' => config('boilerplate.laratrust.permission', 'App\Permission'),
        ]);

        app('router')->aliasMiddleware('role', \Laratrust\Middleware\LaratrustRole::class);
        app('router')->aliasMiddleware('permission', \Laratrust\Middleware\LaratrustPermission::class);
        app('router')->aliasMiddleware('ability', \Laratrust\Middleware\LaratrustAbility::class);

    }

    private function _registerActive()
    {
        $this->app->register(\HieuLe\Active\ActiveServiceProvider::class);
        $loader = AliasLoader::getInstance();
        $loader->alias('Active', \HieuLe\Active\Facades\Active::class);
    }
}
