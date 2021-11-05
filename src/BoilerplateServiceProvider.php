<?php

namespace Sebastienheyd\Boilerplate;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laratrust\LaratrustFacade;
use Laratrust\LaratrustServiceProvider;
use Laratrust\Middleware\LaratrustAbility;
use Laratrust\Middleware\LaratrustPermission;
use Laratrust\Middleware\LaratrustRole;
use Lavary\Menu\Facade;
use Lavary\Menu\ServiceProvider as MenuServiceProvider;
use Sebastienheyd\Boilerplate\Datatables\UsersDatatable;
use Sebastienheyd\Boilerplate\View\Composers\DatatablesComposer;
use Sebastienheyd\Boilerplate\View\Composers\MenuComposer;
use Sebastienheyd\Boilerplate\View\Composers\TinymceLoadComposer;

class BoilerplateServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Instance of AliasLoader.
     *
     * @var AliasLoader
     */
    protected $loader;

    /**
     * Instance of Router.
     *
     * @var Router
     */
    protected $router;

    /**
     * Create a new boilerplate service provider instance.
     *
     * @param  Application  $app
     */
    public function __construct($app)
    {
        $this->loader = AliasLoader::getInstance();
        $this->router = app('router');
        parent::__construct($app);
    }

    /**
     * Bootstrap the boilerplate services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootInConsole();
        }

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/routes/boilerplate.php');
        if (file_exists(base_path('routes/boilerplate.php'))) {
            $this->loadRoutesFrom(base_path('routes/boilerplate.php'));
        }

        // Load migrations, views and translations from current directory
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views/components', 'boilerplate');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'boilerplate');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'boilerplate');

        // Load view composers
        $this->viewComposers();

        // Load directives
        if (version_compare($this->app->version(), '7.0', '<')) {
            $this->bladeDirectives();
        }
    }

    /**
     * Publish files when calling php artisan vendor:publish and add console commands.
     */
    private function bootInConsole()
    {
        $this->publishes([
            __DIR__.'/config' => config_path('boilerplate'),
        ], ['boilerplate', 'boilerplate-config']);

        $this->publishes([
            __DIR__.'/public' => public_path('assets/vendor/boilerplate'),
        ], ['boilerplate', 'boilerplate-public']);

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/boilerplate'),
        ], 'boilerplate-views');

        $this->publishes([
            __DIR__.'/resources/views/dashboard.blade.php' => resource_path('views/vendor/boilerplate/dashboard.blade.php'),
        ], 'boilerplate-dashboard');

        $this->publishes([
            __DIR__.'/resources/lang' => resource_path('lang/vendor/boilerplate'),
        ], 'boilerplate-lang');

        $this->commands([
            Console\Dashboard::class,
            Console\MenuItem::class,
            Console\Permission::class,
            Console\Scaffold::class,
        ]);
    }

    /**
     * Once directive for Laravel 6.
     */
    private function bladeDirectives()
    {
        Blade::directive('once', function () {
            $id = Str::uuid();

            return '<?php if(!defined("'.$id.'")): define("'.$id.'", true); ?>';
        });

        Blade::directive('endonce', function () {
            return '<?php endif; ?>';
        });
    }

    /**
     * Load all necessary view composers, this also allows the compatibility with Laravel 6.
     */
    private function viewComposers()
    {
        // Loading dynamic menu when calling the view
        View::composer('boilerplate::layout.mainsidebar', MenuComposer::class);

        // For datatables locales
        View::composer([
            'boilerplate::load.datatables',
            'boilerplate::load.async.datatables',
        ], DatatablesComposer::class);

        // Check if Media Manager is installed
        View::composer(['boilerplate::load.tinymce', 'boilerplate::load.async.tinymce'], TinymceLoadComposer::class);

        // Components
        $components = [
            'card',
            'codemirror',
            'datatable',
            'datetimepicker',
            'form',
            'icheck',
            'infobox',
            'input',
            'minify',
            'password',
            'select2',
            'smallbox',
            'tinymce',
            'toggle',
        ];

        foreach ($components as $component) {
            View::composer([
                "boilerplate::$component",
                "boilerplate::components.$component",
            ], 'Sebastienheyd\Boilerplate\View\Composers\\'.ucfirst($component).'Composer');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Get config
        foreach (['app', 'laratrust', 'auth', 'menu', 'theme', 'locale'] as $config) {
            $this->mergeConfigFrom(__DIR__."/config/$config.php", "boilerplate.$config");
        }

        // Overriding Laravel config
        config([
            'auth.providers.users.driver' => config('boilerplate.auth.providers.users.driver', 'eloquent'),
            'auth.providers.users.model' => config('boilerplate.auth.providers.users.model', 'App\User'),
            'auth.providers.users.table' => config('boilerplate.auth.providers.users.table', 'users'),
            'log-viewer.route.enabled' => false,
            'log-viewer.menu.filter-route' => 'boilerplate.logs.filter',
            'boilerplate.app.locale' => config('boilerplate.app.locale', config('boilerplate.locale.default')),
        ]);

        if (config('boilerplate.app.logs', true) && ! in_array('daily', config('logging.channels.stack.channels'))) {
            config([
                'logging.channels.stack.channels' => array_merge(['daily'], config('logging.channels.stack.channels')),
            ]);
        }

        $this->router->aliasMiddleware('boilerplatelocale', Middleware\BoilerplateLocale::class);
        $this->router->aliasMiddleware('boilerplateauth', Middleware\BoilerplateAuthenticate::class);
        $this->router->aliasMiddleware('boilerplateguest', Middleware\BoilerplateGuest::class);
        if (version_compare($this->app->version(), '7.0', '<')) {
            $this->router->aliasMiddleware('boilerplateguest', Middleware\BoilerplateGuestL6::class);
        }

        // Loading packages
        $this->registerLaratrust();
        $this->registerMenu();
        $this->registerNavbarItems();
        $this->registerDatatables();

        if (version_compare($this->app->version(), '8.0', '>=')) {
            Paginator::useBootstrap();
        }
    }

    /**
     * Register package santigarcor/laratrust.
     */
    private function registerLaratrust()
    {
        $this->app->register(LaratrustServiceProvider::class);
        $this->loader->alias('Laratrust', LaratrustFacade::class);

        // Overriding config
        config([
            'laratrust.user_models.users' => config('boilerplate.laratrust.user'),
            'laratrust.models.role' => config('boilerplate.laratrust.role'),
            'laratrust.models.permission' => config('boilerplate.laratrust.permission'),
        ]);

        // Registering middlewares
        $this->router->aliasMiddleware('role', LaratrustRole::class);
        $this->router->aliasMiddleware('permission', LaratrustPermission::class);
        $this->router->aliasMiddleware('ability', LaratrustAbility::class);
    }

    /**
     * Register package lavary/laravel-menu.
     */
    private function registerMenu()
    {
        $this->app->register(MenuServiceProvider::class);
        $this->loader->alias('Menu', Facade::class);

        // Menu items repository singleton
        $this->app->singleton('boilerplate.menu.items', function () {
            return new Menu\MenuItemsRepository();
        });

        app('boilerplate.menu.items')->registerMenuItem(Menu\Users::class);

        if (config('boilerplate.app.logs', true)) {
            app('boilerplate.menu.items')->registerMenuItem(Menu\Logs::class);
        }
    }

    /**
     * Register navbar items repository.
     */
    private function registerNavbarItems()
    {
        $this->app->singleton('boilerplate.navbar.items', function () {
            return new Navbar\NavbarItemsRepository();
        });
    }

    private function registerDatatables()
    {
        // Datatables repository singleton
        $this->app->singleton('boilerplate.datatables', function () {
            return new Datatables\DatatablesRepository();
        });

        app('boilerplate.datatables')->registerDatatable(UsersDatatable::class);
    }
}
