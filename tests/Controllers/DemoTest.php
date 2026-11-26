<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers;

use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class DemoTest extends TestCase
{
    public function testDemo()
    {
        UserFactory::create()->admin(true);
        $resource = $this->get('admin/demo');
        $resource->assertSee('Components &amp; plugins demo', false);
    }

    public function testDemoThemeSection()
    {
        UserFactory::create()->admin(true);
        $resource = $this->get('admin/demo');
        $resource->assertSee('id="demo-theme"', false);
        $resource->assertSee('table-striped', false);
        $resource->assertSee('pagination', false);
    }
}
