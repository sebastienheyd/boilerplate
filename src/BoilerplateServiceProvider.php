<?php

namespace Sebastienheyd\Boilerplate;

use Illuminate\Support\ServiceProvider;

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
            __DIR__ . '/resources'      => base_path('resources/'),
            __DIR__ . '/public'         => base_path('public/'),
            __DIR__ . '/fonts'          => base_path('public/fonts'),
            __DIR__ . '/images'         => base_path('public/images'),
            __DIR__ . '/Models'         => app_path('Models'),
            __DIR__ . '/webpack.mix.js' => base_path('webpack.mix.js'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/routes/boilerplate.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        $this->bladeDirectives();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/boilerplate/app.php', 'boilerplate.app',
            __DIR__.'/config/entrust.php', 'entrust'
        );

        $this->registerEntrust();
    }

    /**
     * Register the blade directives
     *
     * @return void
     */
    private function bladeDirectives()
    {
        if (!class_exists('\Blade')) return;

        // Call to Entrust::hasRole
        \Blade::directive('role', function($expression) {
            return "<?php if (\\Entrust::hasRole({$expression})) : ?>";
        });

        \Blade::directive('endrole', function($expression) {
            return "<?php endif; // Entrust::hasRole ?>";
        });

        // Call to Entrust::can
        \Blade::directive('permission', function($expression) {
            return "<?php if (\\Entrust::can({$expression})) : ?>";
        });

        \Blade::directive('endpermission', function($expression) {
            return "<?php endif; // Entrust::can ?>";
        });

        // Call to Entrust::ability
        \Blade::directive('ability', function($expression) {
            return "<?php if (\\Entrust::ability({$expression})) : ?>";
        });

        \Blade::directive('endability', function($expression) {
            return "<?php endif; // Entrust::ability ?>";
        });
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerEntrust()
    {
        $this->app->bind('entrust', function ($app) {
            return new Entrust($app);
        });

        $this->app->alias('entrust', 'Zizaco\Entrust\Entrust');
    }
}
