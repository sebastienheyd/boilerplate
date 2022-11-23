<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers;

use Illuminate\Support\Str;
use Sebastienheyd\Boilerplate\Models\Permission;
use Sebastienheyd\Boilerplate\Models\PermissionCategory;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class LogViewerTest extends TestCase
{
    public function testLogViewer()
    {
        $resource = $this->get('admin/logs');
        $resource->assertRedirect('http://localhost/admin/login');
    }

    public function testLogViewerAsAdmin()
    {
        $user = UserFactory::create()->admin();

        $resource = $this->actingAs($user)->get('admin/logs');
        $resource->assertStatus(200);
        $resource->assertSeeText('The list of logs is empty');
    }

    public function testLogViewerAsUserNoPermission()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $resource = $this->actingAs($user)->get('admin/logs');
        $resource->assertStatus(403);
    }

    public function testLogViewerAsUserWithPermission()
    {
        UserFactory::create()->admin();
        $user = UserFactory::create()->backendUser();

        $permission = Permission::whereName('logs')->first();
        $user->attachPermission($permission);

        $resource = $this->actingAs($user)->get('admin/logs');
        $resource->assertStatus(200);
        $resource->assertSeeText('The list of logs is empty');
    }
}