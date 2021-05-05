<?php

namespace Sebastienheyd\Boilerplate\Tests\Artisan;

use Collective\Html\HtmlServiceProvider;
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
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Illuminate\Cache\CacheServiceProvider::class,
            \Illuminate\Database\DatabaseServiceProvider::class,
            \Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
            \Illuminate\Filesystem\FilesystemServiceProvider::class,
            \Illuminate\Queue\QueueServiceProvider::class,
            \Illuminate\View\ViewServiceProvider::class,
            HtmlServiceProvider::class,
            BoilerplateServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Form' => \Collective\Html\FormFacade::class,
            'Blade' => \Illuminate\Support\Facades\Blade::class,
            'View' => \Illuminate\Support\Facades\View::class,
            'File' => \Illuminate\Support\Facades\File::class,
        ];
    }
}
