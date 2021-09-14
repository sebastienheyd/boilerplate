<?php

namespace Sebastienheyd\Boilerplate\Tests;

class MigrationTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testbench']);
        $this->artisan('migrate', ['--database' => 'testbench'])->run();
    }

    public function testPermissions()
    {
        $res = \DB::table('permissions')->pluck('name')->toArray();
        $this->assertEquals(['backend_access', 'logs', 'roles_crud', 'users_crud'], $res);
    }

    public function testUsersTable()
    {
        $columns = \Schema::getColumnListing('users');
        $this->assertTrue(! in_array('name', $columns));
        $this->assertEmpty(array_diff(['active', 'first_name', 'last_name', 'last_login'], $columns));
    }
}
