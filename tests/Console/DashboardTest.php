<?php

namespace Sebastienheyd\Boilerplate\Tests\Console;

use Sebastienheyd\Boilerplate\Tests\TestCase;

class DashboardTest extends TestCase
{
    public function testDashboard()
    {
        $this->artisan('boilerplate:dashboard')
            ->expectsOutput('Dashboard controller and view has been successfully published!')
            ->assertSuccessful();

        $this->assertFileExists('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileExists('resources/views/vendor/boilerplate/dashboard.blade.php');
    }

    public function testDashboardAlreadyExist()
    {
        $this->artisan('boilerplate:dashboard')
            ->expectsOutput('DashboardController.php already exists in app/Http/Controllers/Boilerplate')
            ->assertFailed();
    }

    public function testDashboardRemoveNoContinue()
    {
        $this->artisan('boilerplate:dashboard', ['--remove' => true])
            ->expectsConfirmation('Continue?')
            ->assertSuccessful();

        $this->assertFileExists('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileExists('resources/views/vendor/boilerplate/dashboard.blade.php');
    }

    public function testDashboardRemove()
    {
        $this->artisan('boilerplate:dashboard', ['--remove' => true])
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsOutput('Custom dashboard has been removed!')
            ->assertSuccessful();

        $this->assertFileDoesNotExist('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileDoesNotExist('resources/views/vendor/boilerplate/dashboard.blade.php');
        $this->assertFileDoesNotExist('/app/Http/Controllers/Boilerplate');
        $this->assertFileDoesNotExist('/resources/views/vendor/boilerplate');
    }

    public function testDashboardAlreadyRemoved()
    {
        $this->artisan('boilerplate:dashboard', ['--remove' => true])
            ->expectsOutput('Custom dashboard is not present, nothing to remove')
            ->assertFailed();
    }
}
