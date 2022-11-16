<?php

namespace Sebastienheyd\Boilerplate\Tests\Console;

use Sebastienheyd\Boilerplate\Tests\TestCase;

class PermissionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->migrate();
    }

    public function testPermission()
    {
        $this->artisan('boilerplate:permission')
            ->expectsQuestion('Name of the permission to create (snake_case)', 'test')
            ->expectsQuestion('Full name of the permission (can be a locale string)', 'Test permission')
            ->expectsQuestion('Full description of the permission (can be a locale string)', 'This is a permission building test')
            ->expectsConfirmation('Create or assign to a permissions group?', 'no')
            ->assertSuccessful();

        $file = glob(base_path('/database/migrations/*_add_test_permission.php'));
        $this->assertTrue(! empty($file));
    }

    public function testGroupPermission()
    {
        $this->artisan('boilerplate:permission')
            ->expectsQuestion('Name of the permission to create (snake_case)', 'test')
            ->expectsQuestion('Full name of the permission (can be a locale string)', 'Test permission')
            ->expectsQuestion('Full description of the permission (can be a locale string)', 'This is a permission building test')
            ->expectsConfirmation('Create or assign to a permissions group?', 'yes')
            ->expectsChoice('Permissions groups', 'Create a new group', ['Create a new group', 'users'])
            ->expectsQuestion('Name of the group (snake_case)', 'group_test')
            ->expectsQuestion('Full name of the group (can be a locale string)', 'Test permission category')
            ->assertSuccessful();

        $file = glob(base_path('/database/migrations/*_add_group_test_permissions.php'));
        $this->assertTrue(! empty($file));
    }
}
