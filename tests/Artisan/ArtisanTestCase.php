<?php

namespace Sebastienheyd\Boilerplate\Tests\Artisan;

use Collective\Html\FormFacade;
use Collective\Html\HtmlServiceProvider;
use Illuminate\Broadcasting\BroadcastServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\View\ViewServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sebastienheyd\Boilerplate\BoilerplateServiceProvider;

abstract class ArtisanTestCase extends OrchestraTestCase
{
    use TestHelper;

    protected const TEST_APP = __DIR__.'/../../testbench';

    protected function getBasePath()
    {
        return self::TEST_APP;
    }

    /**
     * Load package service provider.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            CacheServiceProvider::class,
            DatabaseServiceProvider::class,
            ConsoleSupportServiceProvider::class,
            FilesystemServiceProvider::class,
            QueueServiceProvider::class,
            ViewServiceProvider::class,
            BroadcastServiceProvider::class,
            HtmlServiceProvider::class,
            BoilerplateServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Form' => FormFacade::class,
            'Blade' => Blade::class,
            'View' => View::class,
            'File' => File::class,
            'Broadcast' => Broadcast::class,
        ];
    }
}
