<?php

namespace Sebastienheyd\Boilerplate;

use App\Providers\BroadcastServiceProvider;
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
use Sebastienheyd\Boilerplate\Dashboard\Widgets\LatestErrors;
use Sebastienheyd\Boilerplate\Dashboard\Widgets\UsersNumber;
use Sebastienheyd\Boilerplate\Datatables\Admin\RolesDatatable;
use Sebastienheyd\Boilerplate\Datatables\Admin\UsersDatatable;
use Sebastienheyd\Boilerplate\Middleware\BoilerplateImpersonate;
use Sebastienheyd\Boilerplate\View\Composers\DatatablesComposer;
use Sebastienheyd\Boilerplate\View\Composers\MenuComposer;
use Sebastienheyd\Boilerplate\View\Composers\TinymceLoadComposer;
use Sebastienheyd\Boilerplate\View\ViewFactory;

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

        // Load pusher
        $this->loadPusher();

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/routes/boilerplate.php');
        if (file_exists(base_path('routes/boilerplate.php'))) {
            $this->loadRoutesFrom(base_path('routes/boilerplate.php'));
        }

        // Load migrations, views and translations from current directory
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views/components', 'boilerplate');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'boilerplate');
        $this->loadJSONTranslationsFrom(__DIR__.'/resources/lang');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'boilerplate');

        // Add the impersonate middleware into the default web middleware group
        if (config('boilerplate.app.allowImpersonate', false)) {
            $this->router->pushMiddlewareToGroup('web', BoilerplateImpersonate::class);
        }

        // Load view composers
        $this->viewComposers();
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
        ], ['boilerplate', 'boilerplate-public', 'laravel-assets']);

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/boilerplate'),
        ], 'boilerplate-views');

        $this->publishes([
            __DIR__.'/resources/views/dashboard.blade.php' => resource_path('views/vendor/boilerplate/dashboard.blade.php'),
        ], 'boilerplate-dashboard');

        $this->publishes([
            __DIR__.'/resources/lang' => app()->langPath().'/vendor/boilerplate',
        ], 'boilerplate-lang');

        $this->publishes([
            __DIR__.'/resources/laravel-lang' => app()->langPath(),
        ], ['boilerplate-lang']);

        $this->commands([
            Console\Datatable::class,
            Console\Dashboard::class,
            Console\MenuItem::class,
            Console\Permission::class,
            Console\Scaffold::class,
        ]);
    }

    private function loadPusher()
    {
        if (config('broadcasting.default') === 'pusher') {
            app()->register(BroadcastServiceProvider::class);
        }
    }

    /**
     * Once directive for Laravel 6.
     */
    private function bladeDirectives()
    {
        $this->app->singleton('view', function ($app) {
            $factory = new ViewFactory($app['view.engine.resolver'], $app['view.finder'], $app['events']);
            $factory->setContainer($app);
            $factory->share('app', $app);

            return $factory;
        });

        Blade::directive('once', function () {
            $id = (string) Str::uuid();

            return '<?php if (! $__env->hasRenderedOnce("'.$id.'")): $__env->markAsRenderedOnce("'.$id.'"); ?>';
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
            'colorpicker',
            'datatable',
            'datetimepicker',
            'daterangepicker',
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
        foreach (['app', 'auth', 'dashboard', 'laratrust', 'locale', 'menu', 'theme'] as $config) {
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

        $this->router->aliasMiddleware('boilerplate.locale', Middleware\BoilerplateLocale::class);
        $this->router->aliasMiddleware('boilerplate.auth', Middleware\BoilerplateAuthenticate::class);
        $this->router->aliasMiddleware('boilerplate.guest', Middleware\BoilerplateGuest::class);
        $this->router->aliasMiddleware('boilerplate.emailverified', Middleware\BoilerplateEmailVerified::class);

        if (config('boilerplate.app.allowImpersonate', false)) {
            $this->router->aliasMiddleware('boilerplate.impersonate', Middleware\BoilerplateImpersonate::class);
        }

        // Loading packages
        $this->registerLaratrust();
        $this->registerMenu();
        $this->registerNavbarItems();
        $this->registerDatatables();
        $this->registerDashboardWidgets();

        if (version_compare($this->app->version(), '8.0', '>=')) {
            Paginator::useBootstrap();
        }

        // Load directives for Laravel 6
        if (version_compare($this->app->version(), '7.0', '<')) {
            $this->bladeDirectives();
        }

        $this->app->register(TranslationServiceProvider::class);
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

    private function registerNavbarItems()
    {
        $this->app->singleton('boilerplate.navbar.items', function () {
            return new Navbar\NavbarItemsRepository();
        });
    }

    private function registerDatatables()
    {
        $this->app->singleton('boilerplate.datatables', function () {
            return new Datatables\DatatablesRepository();
        });

        app('boilerplate.datatables')->registerDatatable(UsersDatatable::class, RolesDatatable::class);
    }

    private function registerDashboardWidgets()
    {
        $this->app->singleton('boilerplate.dashboard.widgets', function () {
            return new Dashboard\DashboardWidgetsRepository();
        });

        app('boilerplate.dashboard.widgets')->registerWidget(
            UsersNumber::class,
            LatestErrors::class,
        );
    }
}
