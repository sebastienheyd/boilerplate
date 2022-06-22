<?php

namespace Sebastienheyd\Boilerplate\Tests\Artisan;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

trait TestHelper
{
    /**
     * Create a modified copy of testbench to be used as a template.
     * Before each test, a fresh copy of the template is created.
     */
    protected static function setUpLocalTestbench()
    {
        fwrite(STDOUT, 'Setting up test environment for first use.'.PHP_EOL);
        $files = new Filesystem();
        $files->makeDirectory(self::TEST_APP, 0755, true);
        $files->copyDirectory(__DIR__.'/../../vendor/orchestra/testbench-core/laravel/', self::TEST_APP);

        $files->copyDirectory(__DIR__.'/../../src', self::TEST_APP.'/packages/sebastienheyd/boilerplate/src');
        $files->copy(__DIR__.'/../../composer.json', self::TEST_APP.'/packages/sebastienheyd/boilerplate/composer.json');

        // Modify the composer.json file
        $composer = json_decode($files->get(self::TEST_APP.'/composer.json'), true);
        unset($composer['autoload']['classmap'][1]);
        $composer['require'] = [
            'laravel/framework' => '^6.0|^7.0|^8.0|^9.0',
            'sebastienheyd/boilerplate' => '@dev',
        ];
        $composer['require-dev'] = new \stdClass();
        $composer['minimum-stability'] = 'stable';
        $composer['prefer-stable'] = true;
        $composer['repositories'] = [['type' => 'path', 'url' => 'packages/*/*', 'symlink' => true]];
        $files->put(self::TEST_APP.'/composer.json', json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // Install dependencies
        fwrite(STDOUT, "Installing test environment dependencies\n");
        (new Process(['composer', 'install', '--no-dev', '--quiet'], self::TEST_APP))->run(function ($type, $buffer) {
            fwrite(STDOUT, $buffer);
        });
    }

    protected static function removeTestbench()
    {
        $files = new Filesystem();
        if ($files->exists(self::TEST_APP)) {
            $files->deleteDirectory(self::TEST_APP);
        }
    }

    /**
     * @return bool
     */
    protected function runProcess(array $command)
    {
        $process = new Process($command, self::TEST_APP);
        $process->run();

        return $process->getExitCode() === 0;
    }
}
