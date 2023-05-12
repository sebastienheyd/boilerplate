<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers;

use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class ImpersonateTest extends TestCase
{
    public function testImpersonateSelect()
    {
        UserFactory::create()->admin(true);
        $user = UserFactory::create()->backendUser();

        $resource = $this->post('admin/impersonate/select');
        $this->assertEquals('{"results":[{"id":2,"text":"'.$user->first_name.' '.$user->last_name.'"}]}', $resource->getContent());

        $resource = $this->post('admin/impersonate/select', ['q' => $user->first_name[0]]);
        $this->assertEquals('{"results":[{"id":2,"text":"'.$user->first_name.' '.$user->last_name.'"}]}', $resource->getContent());

        $resource = $this->post('admin/impersonate/select', ['q' => $user->last_name[0]]);
        $this->assertEquals('{"results":[{"id":2,"text":"'.$user->first_name.' '.$user->last_name.'"}]}', $resource->getContent());

        $resource = $this->post('admin/impersonate/select', ['q' => '1']);
        $this->assertEquals('{"results":[]}', $resource->getContent());
    }

    public function testImpersonate()
    {
        $admin = UserFactory::create()->admin();
        UserFactory::create()->backendUser(true);
        UserFactory::create()->user();

        $resource = $this->post('admin/impersonate', ['id' => 1]);
        $this->assertEquals('{"success":false,"message":"Only admins can use the impersonate feature."}', $resource->getContent());

        $resource = $this->actingAs($admin)->post('admin/impersonate', ['id' => 1]);
        $this->assertEquals('{"success":false,"message":"Cannot impersonate an admin."}', $resource->getContent());

        $resource = $this->post('admin/impersonate', ['id' => 3]);
        $this->assertEquals('{"success":false,"message":"Selected user does not have backend access."}', $resource->getContent());

        $resource = $this->post('admin/impersonate', ['id' => 2]);
        $resource->assertSessionHas('impersonate', 2);
        $this->assertEquals('{"success":true}', $resource->getContent());

        $resource = $this->get('admin/impersonate/stop');
        $resource->assertSessionMissing('impersonate');
        $resource->assertRedirect('http://localhost');
    }
}
