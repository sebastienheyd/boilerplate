<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers;

use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class DatatablesTest extends TestCase
{
    public function testDatatablesNotExists()
    {
        UserFactory::create()->admin(true);

        $resource = $this->post('admin/datatables/bad');
        $resource->assertNotFound();

        $resource = $this->post('admin/datatables/bad', [], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);
        $resource->assertNotFound();
    }

    public function testDatatablesNoPermission()
    {
        $user = UserFactory::create()->backendUser(true);

        $resource = $this->actingAs($user)->post('admin/datatables/users', [], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $resource->assertStatus(503);
    }

    public function testUsersDatatables()
    {
        $user = UserFactory::create()->admin(true);
        $altUser = UserFactory::create()->backendUser();
        UserFactory::create()->admin();
        UserFactory::create()->backendUser();

        $altUser->active = false;
        $altUser->save();

        $resource = $this->post('admin/datatables/users', [], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $data = $resource->getOriginalContent()['data'][0];

        $this->assertEquals($user->email, $data['email']);
        $this->assertEquals('<a href="/admin/users/1/edit" class="btn btn-sm btn-primary ml-1" data-action="dt-edit-element"><i class="fas fa-fw fa-pencil-alt"></i></a>', $data['dt-actions']);
    }
}
