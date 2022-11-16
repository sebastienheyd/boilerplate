<?php

namespace Sebastienheyd\Boilerplate\Tests;

use Collective\Html\FormFacade;
use Collective\Html\HtmlServiceProvider;
use Creativeorange\Gravatar\GravatarServiceProvider;
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

abstract class TestCase extends OrchestraTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function migrate()
    {
        $this->loadLaravelMigrationsWithoutRollback(['--database' => 'testbench']);
    }

    protected function getBasePath()
    {
        return Boot::$testbench_path;
    }

    public static function assertFileExists(string $filename, string $message = ''): void
    {
        parent::assertFileExists(Boot::$testbench_path.'/'.ltrim($filename, '/'), $message);
    }

    public static function assertFileDoesNotExist(string $filename, string $message = ''): void
    {
        parent::assertFileDoesNotExist(Boot::$testbench_path.'/'.ltrim($filename, '/'), $message);
    }

    public static function assertDirectoryExists(string $directory, string $message = ''): void
    {
        parent::assertDirectoryExists(Boot::$testbench_path.'/'.ltrim($directory, '/'), $message);
    }

    public static function assertDirectoryDoesNotExist(string $directory, string $message = ''): void
    {
        parent::assertDirectoryDoesNotExist(Boot::$testbench_path.'/'.ltrim($directory, '/'), $message);
    }

    protected function getPackageProviders($app)
    {
        return [
            BoilerplateServiceProvider::class,
            BroadcastServiceProvider::class,
            CacheServiceProvider::class,
            ConsoleSupportServiceProvider::class,
            DatabaseServiceProvider::class,
            FilesystemServiceProvider::class,
            GravatarServiceProvider::class,
            HtmlServiceProvider::class,
            QueueServiceProvider::class,
            ViewServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Blade' => Blade::class,
            'Broadcast' => Broadcast::class,
            'File' => File::class,
            'Form' => FormFacade::class,
            'View' => View::class,
        ];
    }
}
