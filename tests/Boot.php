<?php

namespace Sebastienheyd\Boilerplate\Tests;

use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\BeforeFirstTestHook;
use Illuminate\Filesystem\Filesystem;

class Boot implements BeforeFirstTestHook, AfterLastTestHook
{
    public static $testbench_path = __DIR__.'/../testbench';
    public static $vendor_path = __DIR__.'/../vendor';
    public static $core_path = __DIR__.'/../vendor/orchestra/testbench-core/laravel';

    public function executeBeforeFirstTest(): void
    {
        $fileSystem = new Filesystem();

        if ($fileSystem->exists(self::$testbench_path)) {
            fwrite(STDOUT, 'Cleaning up old environment'.PHP_EOL.PHP_EOL);
            $fileSystem->deleteDirectory(self::$testbench_path);
        }

        fwrite(STDOUT, 'Setting up test environment'.PHP_EOL.PHP_EOL);
        $fileSystem->makeDirectory(self::$testbench_path, 0755, true);
        $fileSystem->delete(self::$core_path.'/vendor');
        $fileSystem->copyDirectory(self::$core_path, self::$testbench_path);
        $fileSystem->copyDirectory(__DIR__.'/../src/database/migrations', self::$testbench_path.'/migrations');
        $fileSystem->link(realpath(self::$vendor_path), self::$core_path.'/vendor');
        $fileSystem->link(realpath(self::$vendor_path), self::$testbench_path.'/vendor');
    }

    public function executeAfterLastTest(): void
    {
        fwrite(STDOUT, PHP_EOL.PHP_EOL.'Cleaning up environment');
//        (new Filesystem())->deleteDirectory(self::$testbench_path);
    }
}