<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers;

use Illuminate\Support\Facades\Log;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class DashboardTest extends TestCase
{
    public function testDashboard()
    {
        UserFactory::create()->admin(true);
        $resource = $this->get('admin');
        $resource->assertSee('id="dashboard-widgets"', false);
    }

    public function testDashboardConfig()
    {
        config(['boilerplate.dashboard.widgets' => [
            ['users-number' => ['color' => 'danger']],
            ['line-break' => []],
            ['latest-errors' => ['length' => 1]],
            ['current-user' => ['color' => 'pink']],
            ['fake' => []],
        ]]);

        UserFactory::create()->admin(true);
        $resource = $this->get('admin');

        $resource->assertSee('data-widget-name="users-number"', false);
        $resource->assertSee('<div class="d-line-break"></div>', false);
        $resource->assertSee('data-widget-name="latest-errors"', false);
    }

    public function testDashboardWidgetAdd()
    {
        UserFactory::create()->admin(true);

        $resource = $this->post('admin/dashboard/widget/add');

        $resource->assertSee('data-action="add-widget" data-slug="users-number"', false);
        $resource->assertSee('data-action="add-widget" data-slug="latest-errors"', false);
    }

    public function testDashboardWidgetLoad()
    {
        UserFactory::create()->admin(true);

        $resource = $this->post('admin/dashboard/widget/load');
        $resource->assertNotFound();

        $resource = $this->post('admin/dashboard/widget/load', ['slug' => 'users-number']);
        $resource->assertSee('data-widget-name="users-number"', false);

        UserFactory::create()->user(true);
        $resource = $this->post('admin/dashboard/widget/load', ['slug' => 'users-number']);
        $resource->assertStatus(403);
    }

    public function testDashboardWidgetEdit()
    {
        UserFactory::create()->admin(true);

        $resource = $this->post('admin/dashboard/widget/edit');
        $resource->assertNotFound();

        $resource = $this->post('admin/dashboard/widget/edit', ['slug' => 'users-number']);
        $resource->assertSee('<form method="POST" action="/admin/dashboard/widget/update">', false);
        $resource->assertSee('<label>Color</label>', false);

        config(['boilerplate.dashboard.widgets' => []]);
        $resource = $this->post('admin/dashboard/widget/edit', ['slug' => 'users-number']);
        $resource->assertSee('<form method="POST" action="/admin/dashboard/widget/update">', false);
        $resource->assertSee('<label>Color</label>', false);

        UserFactory::create()->user(true);
        $resource = $this->post('admin/dashboard/widget/edit', ['slug' => 'users-number']);
        $resource->assertStatus(403);
    }

    public function testDashboardWidgetUpdate()
    {
        UserFactory::create()->admin(true);

        $resource = $this->post('admin/dashboard/widget/update');
        $resource->assertNotFound();

        $resource = $this->post('admin/dashboard/widget/update', ['widget-slug' => 'current-user', 'color' => 'danger']);
        $resource->assertJson(['success' => true]);

        $resource = $this->post('admin/dashboard/widget/update', ['widget-slug' => 'users-number', 'color' => 'secondary']);
        $resource->assertJson(['success' => true]);

        $resource = $this->post('admin/dashboard/widget/update', ['widget-slug' => 'users-number', 'color' => 'primary']);
        $resource->assertJson(['success' => true]);

        $resource = $this->post('admin/dashboard/widget/update', ['widget-slug' => 'latest-errors', 'length' => '100']);
        $resource->assertJson(['success' => false]);

        config(['boilerplate.dashboard.widgets' => []]);
        $resource = $this->post('admin/dashboard/widget/update', ['widget-slug' => 'latest-errors', 'length' => '1']);
        $resource->assertJson(['success' => true]);

        UserFactory::create()->user(true);
        $resource = $this->post('admin/dashboard/widget/update', ['widget-slug' => 'users-number']);
        $resource->assertStatus(403);
    }

    public function testDashboardWidgetSave()
    {
        $user = UserFactory::create()->admin(true);

        $resource = $this->post('admin/dashboard/widget/save');
        $resource->assertStatus(200);

        $resource = $this->post('admin/dashboard/widget/save', ['widgets' => json_encode(['users-number' => []])]);
        $resource->assertStatus(200);
        $this->assertTrue(isset($user->setting('dashboard')['users-number']));
    }

    public function testDashboardLastErrorWidget()
    {
        config(['boilerplate.dashboard.widgets' => [
            ['latest-errors' => ['length' => 2]],
        ]]);

        UserFactory::create()->admin(true);

        Log::alert('test 1');
        $resource = $this->get('admin');
        $resource->assertSee(__('boilerplate::dashboard.latest-errors.no-error'), false);

        Log::error("test 2\n[stacktrace]\n#1 /fakepath/fakefile.php(22): fakeerror()\n#2 main\n\"}");
        Log::error("test 3\n[stacktrace]\n#1 /fakepath/fakefile.php(22): fakeerror()\n#2 main\n\"}");
        Log::error("test 4\n[stacktrace]\n#1 /fakepath/fakefile.php(22): fakeerror()\n#2 main\n\"}");
        $resource = $this->get('admin');
        $resource->assertSee('<div class="small">test 2</div>', false);
    }
}
