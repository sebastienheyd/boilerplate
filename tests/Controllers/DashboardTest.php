<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers;

use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class DashboardTest extends TestCase
{
    public function testDashboard()
    {
        UserFactory::create()->admin(true);
        $resource = $this->get('admin');
        $resource->assertSee('Components &amp; plugins demo', false);
    }
}
