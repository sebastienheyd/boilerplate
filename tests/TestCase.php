<?php

namespace Sebastienheyd\Boilerplate\Tests;

use Arcanedev\LogViewer\LogViewerServiceProvider;
use Arcanedev\LogViewer\Providers\DeferredServicesProvider;
use Creativeorange\Gravatar\GravatarServiceProvider;
use Illuminate\Auth\AuthServiceProvider;
use Illuminate\Broadcasting\BroadcastServiceProvider;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
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
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Laravel\ServiceProvider;
use Laratrust\LaratrustServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use PHPUnit\Framework\Constraint\DirectoryExists;
use PHPUnit\Framework\Constraint\FileExists;
use PHPUnit\Framework\Constraint\LogicalNot;
use SebastienHeyd\Active\ActiveServiceProvider;
use Sebastienheyd\Boilerplate\BoilerplateServiceProvider;
use Spatie\Html\HtmlServiceProvider;
use Yajra\DataTables\DataTablesServiceProvider;

class TestCase extends OrchestraTestCase
{
    public static string $vendor_path = __DIR__.'/../vendor';
    public static string $core_path = __DIR__.'/../vendor/orchestra/testbench-core/laravel';

    public static bool $once = false;
    public static bool $init = false;

    protected function getEnvironmentSetUp($app): void
    {
        $config = require 'config.php';
        config($config);
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

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        if (self::$once === false) {
            echo 'Tested version : Laravel '.Laravel::VERSION.' (PHP '.PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'.PHP_RELEASE_VERSION.')'.PHP_EOL;
            echo 'SQLite version : '.\SQLite3::version()['versionString'].PHP_EOL.PHP_EOL;
            self::$once = true;
        }

        self::refreshTestBench();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        self::deleteTestBench();
    }

    protected static function backupTestBench(): void
    {
        $fileSystem = new Filesystem();
        if (! $fileSystem->exists(self::$core_path.'.backup')) {
            $fileSystem->makeDirectory(self::$core_path.'.backup', 0755, true);
            $fileSystem->delete(self::$core_path.'/vendor');
            $fileSystem->copyDirectory(self::$core_path, self::$core_path.'.backup');
            $fileSystem->link(realpath(self::$vendor_path), self::$core_path.'/vendor');
        }
    }

    protected static function deleteTestBench(): void
    {
        $fileSystem = new Filesystem();

        if ($fileSystem->exists(self::$core_path.'.backup')) {
            $fileSystem->deleteDirectory(self::$core_path);
            $fileSystem->copyDirectory(self::$core_path.'.backup', self::$core_path);
            $fileSystem->deleteDirectory(self::$core_path.'.backup');
        }
    }

    protected static function refreshTestBench(): void
    {
        self::deleteTestBench();
        self::backupTestBench();
    }

    public static function assertFileExistsTestBench(string $filename, string $message = ''): void
    {
        parent::assertFileExists(self::$core_path.'/'.ltrim($filename, '/'), $message);
    }

    public static function assertFileDoesNotExistTestBench(string $filename, string $message = ''): void
    {
        static::assertThat($filename, new LogicalNot(new FileExists), $message);
    }

    public static function assertDirectoryExistsTestBench(string $directory, string $message = ''): void
    {
        parent::assertDirectoryExists(self::$core_path.'/'.ltrim($directory, '/'), $message);
    }

    public static function assertDirectoryDoesNotExistTestBench(string $directory, string $message = ''): void
    {
        static::assertThat($directory, new LogicalNot(new DirectoryExists), $message);
    }

    protected function getLastMail(): ?array
    {
        $mail = $this->getMails()->last();

        if ($mail === null) {
            return null;
        }

        if (in_array('getOriginalMessage', get_class_methods($mail))) {
            return [
                'subject' => $mail->getOriginalMessage()->getSubject(),
                'body'    => $mail->getOriginalMessage()->getHtmlBody(),
            ];
        }

        return [
            'subject' => $mail->getSubject(),
            'body'    => $mail->getBody(),
        ];
    }

    protected function getMails()
    {
        return $this->app->make('mailer')->getSymfonyTransport()->messages();
    }

    protected function getPackageProviders($app): array
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
            DataTablesServiceProvider::class,
            DatabaseServiceProvider::class,
            DeferredServicesProvider::class,
            EncryptionServiceProvider::class,
            EventServiceProvider::class,
            FilesystemServiceProvider::class,
            FoundationServiceProvider::class,
            GravatarServiceProvider::class,
            HashServiceProvider::class,
            HtmlServiceProvider::class,
            LaratrustServiceProvider::class,
            LogViewerServiceProvider::class,
            MailServiceProvider::class,
            NotificationServiceProvider::class,
            QueueServiceProvider::class,
            ServiceProvider::class,
            SessionServiceProvider::class,
            TranslationServiceProvider::class,
            ValidationServiceProvider::class,
            ViewServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Blade'        => Blade::class,
            'Broadcast'    => Broadcast::class,
            'File'         => File::class,
            'Image'        => Image::class,
            'Mail'         => Mail::class,
            'Notification' => Notification::class,
            'Validator'    => Validator::class,
            'View'         => View::class,
        ];
    }
}
