<?php

namespace Sebastienheyd\Boilerplate\Tests\Artisan;

class ArtisanTest extends ArtisanTestCase
{
    public static function setUpBeforeClass(): void
    {
        self::removeTestbench();
        self::setUpLocalTestbench();
        parent::setUpBeforeClass();
    }

    public static function tearDownAfterClass(): void
    {
        self::removeTestbench();
        parent::tearDownAfterClass();
    }

    public function testBoilerplatePublish()
    {
        $this->artisan('vendor:publish', ['--tag' => 'boilerplate'])
            ->expectsOutput('Publishing complete.')
            ->assertExitCode(0);

        $this->assertTrue(is_dir(self::TEST_APP.'/public/assets/vendor/boilerplate'));
        $this->assertTrue(is_dir(self::TEST_APP.'/config/boilerplate'));
    }

    public function testMenuItem()
    {
        $this->artisan('boilerplate:menuitem', ['name' => 'menu'])
            ->assertExitCode(0);

        $this->assertTrue(is_file(self::TEST_APP.'/app/Menu/Menu.php'));

        $this->artisan('boilerplate:menuitem', ['name' => 'submenu', '--submenu' => true])
            ->assertExitCode(0);

        $this->assertTrue(is_file(self::TEST_APP.'/app/Menu/Submenu.php'));
    }

    public function testPermission()
    {
        $this->artisan('boilerplate:permission')
            ->expectsQuestion('Name of the permission to create (snake_case)', 'test')
            ->expectsQuestion('Full name of the permission (can be a locale string)', 'Test permission')
            ->expectsQuestion('Full description of the permission (can be a locale string)', 'This is a permission building test')
            ->expectsConfirmation('Create or assign to a permissions group?', 'N')
            ->assertExitCode(0);

        $file = glob(self::TEST_APP.'/database/migrations/*_add_test_permission.php');
        $this->assertTrue(! empty($file));
    }

    public function testDashboard()
    {
        $this->artisan('boilerplate:dashboard')
            ->expectsOutput('Dashboard controller and view has been successfully published!')
            ->assertExitCode(0);

        $this->assertTrue(is_file(self::TEST_APP.'/app/Http/Controllers/Boilerplate/DashboardController.php'));
        $this->assertTrue(is_file(self::TEST_APP.'/resources/views/vendor/boilerplate/dashboard.blade.php'));
    }

    public function testDashboardRemove()
    {
        $this->artisan('boilerplate:dashboard', ['--remove' => true])
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsOutput('Custom dashboard has been removed!')
            ->assertExitCode(0);

        $this->assertTrue(! is_file(self::TEST_APP.'/app/Http/Controllers/Boilerplate/DashboardController.php'));
        $this->assertTrue(! is_file(self::TEST_APP.'/resources/views/vendor/boilerplate/dashboard.blade.php'));
        $this->assertTrue(! is_dir(self::TEST_APP.'/app/Http/Controllers/Boilerplate'));
        $this->assertTrue(! is_dir(self::TEST_APP.'/resources/views/vendor/boilerplate'));
    }

    public function testScaffold()
    {
        $this->artisan('boilerplate:scaffold')
            ->expectsConfirmation('Continue?', 'yes')
            ->assertExitCode(0);

        $this->assertTrue(is_dir(self::TEST_APP.'/app/Http/Controllers/Boilerplate'));
        $this->assertTrue(is_dir(self::TEST_APP.'/app/Events/Boilerplate'));
        $this->assertTrue(is_dir(self::TEST_APP.'/app/Models/Boilerplate'));
        $this->assertTrue(is_dir(self::TEST_APP.'/app/Notifications/Boilerplate'));
        $this->assertTrue(is_dir(app()->langPath().'/vendor/boilerplate'));
        $this->assertTrue(is_dir(self::TEST_APP.'/resources/views/vendor/boilerplate'));
        $this->assertTrue(is_dir(self::TEST_APP.'/public/assets/vendor/boilerplate'));
    }

    public function testScaffoldRemove()
    {
        $this->artisan('boilerplate:scaffold', ['--remove' => true])
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsConfirmation('Remove custom dashboard?')
            ->assertExitCode(0);

        $this->assertTrue(is_file(self::TEST_APP.'/app/Http/Controllers/Boilerplate/DashboardController.php'));
        $this->assertTrue(is_file(self::TEST_APP.'/resources/views/vendor/boilerplate/dashboard.blade.php'));

        $this->artisan('boilerplate:scaffold', ['--remove' => true])
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsConfirmation('Remove custom dashboard?', 'yes')
            ->assertExitCode(0);

        $this->assertTrue(! is_dir(self::TEST_APP.'/app/Http/Controllers/Boilerplate'));
        $this->assertTrue(! is_dir(self::TEST_APP.'/resources/views/vendor/boilerplate'));
        $this->assertTrue(! is_dir(self::TEST_APP.'/app/Events/Boilerplate'));
        $this->assertTrue(! is_dir(self::TEST_APP.'/app/Models/Boilerplate'));
        $this->assertTrue(! is_dir(self::TEST_APP.'/app/Notifications/Boilerplate'));
        $this->assertTrue(! is_dir(self::TEST_APP.'/resources/lang/vendor/boilerplate'));
    }

    public function testDashboardRemoveWithScaffold()
    {
        $this->artisan('boilerplate:scaffold')
            ->expectsConfirmation('Continue?', 'yes')
            ->assertExitCode(0);

        $this->artisan('boilerplate:dashboard', ['--remove' => true])
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsOutput('Custom dashboard has been removed!')
            ->assertExitCode(0);

        $this->assertTrue(! is_file(self::TEST_APP.'/app/Http/Controllers/Boilerplate/DashboardController.php'));
        $this->assertTrue(! is_file(self::TEST_APP.'/resources/views/vendor/boilerplate/dashboard.blade.php'));
        $this->assertTrue(is_dir(self::TEST_APP.'/app/Http/Controllers/Boilerplate'));
        $this->assertTrue(is_dir(self::TEST_APP.'/resources/views/vendor/boilerplate'));
    }
}
