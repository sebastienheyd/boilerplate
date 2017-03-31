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
        $this->mergeConfigFrom(__DIR__.'/config/boilerplate/entrust.php', 'boilerplate.entrust');
        $this->mergeConfigFrom(__DIR__.'/config/boilerplate/auth.php', 'boilerplate.auth');
        $this->mergeConfigFrom(__DIR__.'/config/boilerplate/cache.php', 'boilerplate.cache');

        config([
            'auth.providers.users.driver' => config('boilerplate.auth.providers.users.driver', 'eloquent'),
            'auth.providers.users.model' => config('boilerplate.auth.providers.users.model', 'App\User'),
            'auth.providers.users.table' => config('boilerplate.auth.providers.users.table', 'users'),
            'cache.default' => config('boilerplate.cache.default', 'array'),
        ]);

        $this->_registerEntrust();
        $this->_registerLaravelCollective();
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
    private function _registerEntrust()
    {
        $this->app->register(\Zizaco\Entrust\EntrustServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Entrust', \Zizaco\Entrust\EntrustFacade::class);

        config([
            'entrust.role' => config('boilerplate.entrust.role', 'App\Role'),
            'entrust.permission' => config('boilerplate.entrust.permission', 'App\Permission'),
        ]);
    }
}
