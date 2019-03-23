<?php

namespace Sebastienheyd\Boilerplate\Tests;

class ConfigTest extends TestCase
{
    public function testAuthProvidersUsersConfig()
    {
        $config = config('auth.providers.users');

        $this->assertEquals([
            'driver' => 'eloquent',
            'model'  => 'Sebastienheyd\Boilerplate\Models\User',
            'table'  => 'users',
        ], $config);
    }

    public function testLogViewerConfig()
    {
        $this->assertTrue(in_array('daily', config('logging.channels.stack.channels')));
        $this->assertEquals(false, config('log-viewer.route.enabled'));
        $this->assertEquals('boilerplate.logs.filter', config('log-viewer.menu.filter-route'));
    }

    public function testLaratrustConfig()
    {
        $this->assertEquals('Sebastienheyd\Boilerplate\Models\User', config('laratrust.user_models.users'));
        $this->assertEquals('Sebastienheyd\Boilerplate\Models\Role', config('laratrust.models.role'));
        $this->assertEquals('Sebastienheyd\Boilerplate\Models\Permission', config('laratrust.models.permission'));
    }
}
