<?php

namespace Sebastienheyd\Boilerplate\Tests;

use Arcanedev\LogViewer\LogViewerServiceProvider;
use Arcanedev\LogViewer\Providers\DeferredServicesProvider;
use Collective\Html\FormFacade;
use Creativeorange\Gravatar\GravatarServiceProvider;
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
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Notifications\NotificationServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\View\ViewServiceProvider;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use Laratrust\LaratrustServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use PHPUnit\Framework\Constraint\DirectoryExists;
use PHPUnit\Framework\Constraint\FileExists;
use PHPUnit\Framework\Constraint\LogicalNot;
use PHPUnit\Framework\Constraint\StringContains;
use SebastienHeyd\Active\ActiveServiceProvider;
use Sebastienheyd\Boilerplate\BoilerplateServiceProvider;
use Spatie\Html\HtmlServiceProvider;
use Yajra\DataTables\DataTablesServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    public static $testbench_path = __DIR__.'/../testbench';
    public static $vendor_path = __DIR__.'/../vendor';
    public static $core_path = __DIR__.'/../vendor/orchestra/testbench-core/laravel';
    public static $init = false;
    public static $once = false;

    protected function getEnvironmentSetUp($app)
    {
        $config = require 'config.php';
        config($config);
    }

    public function artisan($command, $parameters = [])
    {
        if ($this->minLaravelVersion('8.0')) {
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

        if (self::$once === false) {
            echo 'Tested version : Laravel '.Laravel::VERSION.' (PHP '.PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'.PHP_RELEASE_VERSION.')'.PHP_EOL;
            echo 'SQLite version : '.\SQLite3::version()['versionString'].PHP_EOL.PHP_EOL;
            self::$once = true;
        }

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
            $fileSystem->deleteDirectory(self::$testbench_path);
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

    protected function minLaravelVersion($version)
    {
        return version_compare(Laravel::VERSION, $version, '>=');
    }

    protected function getLastMail()
    {
        $mail = $this->getMails()->last();

        if ($mail === null) {
            return null;
        }

        if (in_array('getOriginalMessage', get_class_methods($mail))) {
            return [
                'subject' => $mail->getOriginalMessage()->getSubject(),
                'body' => $mail->getOriginalMessage()->getHtmlBody(),
            ];
        }

        return [
            'subject' => $mail->getSubject(),
            'body' => $mail->getBody(),
        ];
    }

    protected function getMails()
    {
        if ($this->minLaravelVersion('9')) {
            return $this->app->make('mailer')->getSymfonyTransport()->messages();
        }

        return app()->make('mailer')->getSwiftMailer()->getTransport()->messages();
    }

    public static function applicationBasePath()
    {
        return self::$testbench_path;
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

    public static function assertStringContainsString(string $needle, string $haystack, string $message = ''): void
    {
        if (method_exists(static::class, 'assertStringContainsString')) {
            parent::assertStringContainsString($needle, $haystack, $message);
        } else {
            static::assertTrue(strstr($haystack, $needle) !== false, $message);
        }
    }

    protected function getPackageProviders($app)
    {
        return [
            ActiveServiceProvider::class,
            AuthServiceProvider::class,
            BoilerplateServiceProvider::class,
            BroadcastServiceProvider::class,
            BusServiceProvider::class,
            CacheServiceProvider::class,
            ConsoleSupportServiceProvider::class,
            CookieServiceProvider::class,
            DatabaseServiceProvider::class,
            DataTablesServiceProvider::class,
            DeferredServicesProvider::class,
            EncryptionServiceProvider::class,
            EventServiceProvider::class,
            FilesystemServiceProvider::class,
            FoundationServiceProvider::class,
            GravatarServiceProvider::class,
            HashServiceProvider::class,
            HtmlServiceProvider::class,
            ImageServiceProvider::class,
            LaratrustServiceProvider::class,
            LogViewerServiceProvider::class,
            MailServiceProvider::class,
            NotificationServiceProvider::class,
            QueueServiceProvider::class,
            SessionServiceProvider::class,
            TranslationServiceProvider::class,
            ValidationServiceProvider::class,
            ViewServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Blade'        => Blade::class,
            'Broadcast'    => Broadcast::class,
            'File'         => File::class,
            'Form'         => FormFacade::class,
            'Mail'         => Mail::class,
            'Notification' => Notification::class,
            'View'         => View::class,
            'Image'        => Image::class,
            'Validator'    => Validator::class,
        ];
    }
}
