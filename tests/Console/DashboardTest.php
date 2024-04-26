<?php

namespace Sebastienheyd\Boilerplate\Tests\Console;

use Sebastienheyd\Boilerplate\Tests\TestCase;

class DashboardTest extends TestCase
{
    public function testDashboard()
    {
        $fakeRouteCache = base_path('bootstrap/cache/routes-v7.php');
        touch($fakeRouteCache);

        $this->artisan('boilerplate:dashboard')
            ->expectsOutput('Dashboard controller and view has been successfully published!')
            ->assertSuccessful();

        $this->assertFileExistsTestBench('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileExistsTestBench('resources/views/vendor/boilerplate/dashboard.blade.php');

        unlink($fakeRouteCache);
    }

    public function testDashboardAlreadyExist()
    {
        $this->artisan('boilerplate:dashboard')
            ->expectsOutput('DashboardController.php already exists in app/Http/Controllers/Boilerplate')
            ->assertSuccessful();
    }

    public function testDashboardRemoveNoContinue()
    {
        $this->artisan('boilerplate:dashboard', ['--remove' => true])
            ->expectsConfirmation('Continue?')
            ->assertSuccessful();

        $this->assertFileExistsTestBench('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileExistsTestBench('resources/views/vendor/boilerplate/dashboard.blade.php');
    }

    public function testDashboardRemove()
    {
        $fakeRouteCache = base_path('bootstrap/cache/routes-v7.php');
        touch($fakeRouteCache);

        $this->artisan('boilerplate:dashboard', ['--remove' => true])
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsOutput('Custom dashboard has been removed!')
            ->assertSuccessful();

        $this->assertFileDoesNotExistTestBench('app/Http/Controllers/Boilerplate/DashboardController.php');
        $this->assertFileDoesNotExistTestBench('resources/views/vendor/boilerplate/dashboard.blade.php');
        $this->assertFileDoesNotExistTestBench('/app/Http/Controllers/Boilerplate');
        $this->assertFileDoesNotExistTestBench('/resources/views/vendor/boilerplate');

        unlink($fakeRouteCache);
    }

    public function testDashboardAlreadyRemoved()
    {
        $this->artisan('boilerplate:dashboard', ['--remove' => true])
            ->expectsOutput('Custom dashboard is not present, nothing to remove')
            ->assertSuccessful();
    }
}
