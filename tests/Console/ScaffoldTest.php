<?php

namespace Sebastienheyd\Boilerplate\Tests\Console;

use Sebastienheyd\Boilerplate\Tests\TestCase;

class ScaffoldTest extends TestCase
{
    public function testScaffold()
    {
        unlink(config_path('boilerplate/menu.php'));

        $this->artisan('boilerplate:scaffold')
            ->expectsConfirmation('Continue?')
            ->assertSuccessful();

        $this->artisan('boilerplate:scaffold')
            ->expectsConfirmation('Continue?', 'yes')
            ->assertSuccessful();

        $this->assertDirectoryExistsTestBench('app/Http/Controllers/Boilerplate');
        $this->assertDirectoryExistsTestBench('app/Events/Boilerplate');
        $this->assertDirectoryExistsTestBench('app/Models/Boilerplate');
        $this->assertDirectoryExistsTestBench('app/Notifications/Boilerplate');
        $this->assertDirectoryExistsTestBench('lang/vendor/boilerplate');
        $this->assertDirectoryExistsTestBench('resources/views/vendor/boilerplate');
        $this->assertDirectoryExistsTestBench('public/assets/vendor/boilerplate');
    }

    public function testScaffoldRemove()
    {
        $this->artisan('boilerplate:scaffold', ['--remove' => true])
            ->expectsConfirmation('Continue?')
            ->assertSuccessful();

        $this->artisan('boilerplate:scaffold', ['--remove' => true])
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsConfirmation('Remove custom dashboard?')
            ->assertSuccessful();

        $this->assertFileExistsTestBench('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileExistsTestBench('resources/views/vendor/boilerplate/dashboard.blade.php');
        $this->assertDirectoryDoesNotExistTestBench('app/Events/Boilerplate');
        $this->assertDirectoryDoesNotExistTestBench('app/Models/Boilerplate');
        $this->assertDirectoryDoesNotExistTestBench('app/Notifications/Boilerplate');
        $this->assertDirectoryDoesNotExistTestBench('lang/vendor/boilerplate');

        $this->artisan('boilerplate:scaffold', ['--remove' => true])
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsConfirmation('Remove custom dashboard?', 'yes')
            ->assertSuccessful();

        $this->assertFileDoesNotExistTestBench('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileDoesNotExistTestBench('resources/views/vendor/boilerplate/dashboard.blade.php');
        $this->assertDirectoryDoesNotExistTestBench('app/Http/Controllers/Boilerplate');
        $this->assertDirectoryDoesNotExistTestBench('resources/views/vendor/boilerplate');
    }

    public function testScaffoldBadDatabase()
    {
        app('config')->set('database.default', 'fake');

        $this->artisan('boilerplate:scaffold')
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsOutput('Database is not available')
            ->assertSuccessful();

        $this->artisan('boilerplate:scaffold', ['--remove' => true])
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsConfirmation('Remove custom dashboard?', 'yes')
            ->expectsOutput('Database is not available')
            ->assertSuccessful();

        app('config')->set('database.default', 'testbench');

        $this->assertFileDoesNotExistTestBench('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileDoesNotExistTestBench('resources/views/vendor/boilerplate/dashboard.blade.php');
        $this->assertDirectoryDoesNotExistTestBench('app/Http/Controllers/Boilerplate');
        $this->assertDirectoryDoesNotExistTestBench('resources/views/vendor/boilerplate');
    }
}
