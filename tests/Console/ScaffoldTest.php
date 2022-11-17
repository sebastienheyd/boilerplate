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

        $this->assertDirectoryExists('app/Http/Controllers/Boilerplate');
        $this->assertDirectoryExists('app/Events/Boilerplate');
        $this->assertDirectoryExists('app/Models/Boilerplate');
        $this->assertDirectoryExists('app/Notifications/Boilerplate');
        $this->assertDirectoryExists('lang/vendor/boilerplate');
        $this->assertDirectoryExists('resources/views/vendor/boilerplate');
        $this->assertDirectoryExists('public/assets/vendor/boilerplate');
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

        $this->assertFileExists('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileExists('resources/views/vendor/boilerplate/dashboard.blade.php');
        $this->assertDirectoryDoesNotExist('app/Events/Boilerplate');
        $this->assertDirectoryDoesNotExist('app/Models/Boilerplate');
        $this->assertDirectoryDoesNotExist('app/Notifications/Boilerplate');
        $this->assertDirectoryDoesNotExist('resources/lang/vendor/boilerplate');

        $this->artisan('boilerplate:scaffold', ['--remove' => true])
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsConfirmation('Remove custom dashboard?', 'yes')
            ->assertSuccessful();

        $this->assertFileDoesNotExist('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileDoesNotExist('resources/views/vendor/boilerplate/dashboard.blade.php');
        $this->assertDirectoryDoesNotExist('app/Http/Controllers/Boilerplate');
        $this->assertDirectoryDoesNotExist('resources/views/vendor/boilerplate');
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

        $this->assertFileDoesNotExist('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileDoesNotExist('resources/views/vendor/boilerplate/dashboard.blade.php');
        $this->assertDirectoryDoesNotExist('app/Http/Controllers/Boilerplate');
        $this->assertDirectoryDoesNotExist('resources/views/vendor/boilerplate');
    }
}
