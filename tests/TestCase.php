<?php

namespace Sebastienheyd\Boilerplate\Tests;

use Collective\Html\FormFacade;
use Collective\Html\HtmlServiceProvider;
use Creativeorange\Gravatar\GravatarServiceProvider;
use HieuLe\Active\ActiveServiceProvider;
use Illuminate\Auth\AuthServiceProvider;
use Illuminate\Broadcasting\BroadcastServiceProvider;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Cookie\CookieServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Encryption\EncryptionServiceProvider;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\Application as Laravel;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Foundation\Testing\PendingCommand;
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\View\ViewServiceProvider;
use Laratrust\LaratrustServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use PHPUnit\Framework\Constraint\DirectoryExists;
use PHPUnit\Framework\Constraint\FileExists;
use PHPUnit\Framework\Constraint\LogicalNot;
use Sebastienheyd\Boilerplate\BoilerplateServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    public static $testbench_path = __DIR__.'/../testbench';
    public static $vendor_path = __DIR__.'/../vendor';
    public static $core_path = __DIR__.'/../vendor/orchestra/testbench-core/laravel';
    public static $init = false;
    public static $isLaravelEqualOrGreaterThan7;

    protected function getEnvironmentSetUp($app)
    {
        config([
            'app.key' => 'base64:Wo2VgRys/LE/wWcQhIh3GrKb+3GbvE0TEq41WMm1UkQ=',
            'app.cipher' => 'AES-256-CBC',
            'app.locale' => 'en',
            'session.driver' => 'array',
            'queue.driver' => 'sync',
            'database.default' => 'testbench',
            'database.connections.testbench' => [
                'driver'   => 'sqlite',
                'database' => ':memory:',
                'prefix'   => '',
            ]
        ]);
    }

    public function artisan($command, $parameters = [])
    {
        if (version_compare($this->app->version(), '7.0', '>=')) {
            return parent::artisan($command, $parameters);
        }

        if (! $this->mockConsoleOutput) {
            return $this->app[Kernel::class]->call($command, $parameters);
        }

        $this->beforeApplicationDestroyed(function () {
            if (count($this->expectedQuestions)) {
                $this->fail('Question "'.Arr::first($this->expectedQuestions)[0].'" was not asked.');
            }

            if (count($this->expectedOutput)) {
                $this->fail('Output "'.Arr::first($this->expectedOutput).'" was not printed.');
            }
        });

        return new \Sebastienheyd\Boilerplate\Tests\PendingCommand($this, $this->app, $command, $parameters);
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $fileSystem = new Filesystem();

        if ($fileSystem->exists(self::$testbench_path)) {
            $fileSystem->deleteDirectory(self::$testbench_path);
        }

        $fileSystem->makeDirectory(self::$testbench_path, 0755, true);
        $fileSystem->delete(self::$core_path.'/vendor');
        $fileSystem->copyDirectory(self::$core_path, self::$testbench_path);
        $fileSystem->link(realpath(self::$vendor_path), self::$core_path.'/vendor');
        $fileSystem->link(realpath(self::$vendor_path), self::$testbench_path.'/vendor');
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        $fileSystem = new Filesystem();

        if ($fileSystem->exists(self::$testbench_path)) {
//            $fileSystem->deleteDirectory(self::$testbench_path);
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('view:clear');

        if (self::$init === false) {
            $this->artisan('vendor:publish', ['--tag' => 'boilerplate']);
            $this->loadLaravelMigrations(['--database' => 'testbench']);
            $this->artisan('migrate', ['--database' => 'testbench'])->run();
            self::$init = true;
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::$init = false;
    }

    protected function isLaravelEqualOrGreaterThan7()
    {
        if (self::$isLaravelEqualOrGreaterThan7 === null) {
            self::$isLaravelEqualOrGreaterThan7 = version_compare(Laravel::VERSION, '7.0', '>=');
        }

        return self::$isLaravelEqualOrGreaterThan7;
    }

    protected function getBasePath()
    {
        return self::$testbench_path;
    }

    public static function assertFileExists(string $filename, string $message = ''): void
    {
        parent::assertFileExists(self::$testbench_path.'/'.ltrim($filename, '/'), $message);
    }

    public static function assertFileDoesNotExist(string $filename, string $message = ''): void
    {
        static::assertThat($filename, new LogicalNot(new FileExists), $message);
    }

    public static function assertDirectoryExists(string $directory, string $message = ''): void
    {
        parent::assertDirectoryExists(self::$testbench_path.'/'.ltrim($directory, '/'), $message);
    }

    public static function assertDirectoryDoesNotExist(string $directory, string $message = ''): void
    {
        static::assertThat($directory, new LogicalNot(new DirectoryExists), $message);
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
            HtmlServiceProvider::class,
            QueueServiceProvider::class,
            ViewServiceProvider::class,
            GravatarServiceProvider::class,
            ActiveServiceProvider::class,
            LaratrustServiceProvider::class,
            TranslationServiceProvider::class,
            SessionServiceProvider::class,
            ValidationServiceProvider::class,
            QueueServiceProvider::class,
            EventServiceProvider::class,
            BusServiceProvider::class,
            AuthServiceProvider::class,
            HashServiceProvider::class,
            CookieServiceProvider::class,
            EncryptionServiceProvider::class,
            FoundationServiceProvider::class,
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
