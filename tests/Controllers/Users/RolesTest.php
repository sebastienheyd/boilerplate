<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers\Users;

use Sebastienheyd\Boilerplate\Models\Role;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class RolesTest extends TestCase
{
    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = UserFactory::create()->admin();
        $this->user = UserFactory::create()->backendUser();
    }

    public function testRoles()
    {
        $resource = $this->actingAs($this->admin)->get('admin/roles');
        $resource->assertStatus(200);
        $resource->assertSeeTextInOrder(['Role management', 'Role list']);
    }

    public function testRolesNoPermission()
    {
        $resource = $this->actingAs($this->user)->get('admin/roles');
        $resource->assertStatus(403);
    }

    public function testRoleCreateForm()
    {
        $resource = $this->actingAs($this->admin)->get('admin/roles/create');
        $resource->assertStatus(200);
        $resource->assertSeeInOrder(['Role management', 'Add a role', '<h3 class="card-title">Parameters</h3>', '<h3 class="card-title">Permissions</h3>'], false);
    }

    public function testRoleCreateFormPostFail()
    {
        $resource = $this->actingAs($this->admin)->post('admin/roles');

        $resource->assertSessionHasErrors([
            'name'         => 'The name field is required.',
            'display_name' => 'The label field is required.',
            'description'  => 'The description field is required.',
        ]);
    }

    public function testRoleCreateFormPost()
    {
        $resource = $this->actingAs($this->admin)->post('admin/roles', [
            'display_name'  => 'Test',
            'description'   => 'Role for testing',
            'permission[2]' => 'on',
        ]);

        $this->assertTrue(Role::find(3) !== null);
        $resource->assertStatus(302);
        $resource->assertRedirect('http://localhost/admin/roles/3/edit');
    }

    public function testRoleEditForm()
    {
        Role::create([
            'name'         => 'test',
            'display_name' => 'Test',
            'description'  => 'Test role',
        ]);

        $resource = $this->actingAs($this->admin)->get('admin/roles/3/edit');
        $resource->assertStatus(200);
        $resource->assertSeeInOrder([
            'action="/admin/roles/3"',
            'value="Test"',
            'value="Test role"',
        ], false);
    }

    public function testRoleEditFormPostFail()
    {
        Role::create([
            'name'         => 'test',
            'display_name' => 'Test',
            'description'  => 'Test role',
        ]);

        $resource = $this->actingAs($this->admin)->post('admin/roles/3', [
            '_method' => 'PUT',
        ]);

        $resource->assertSessionHasErrors([
            'display_name' => 'The label field is required.',
            'description'  => 'The description field is required.',
        ]);
    }

    public function testRoleEditFormPost()
    {
        Role::create([
            'name'         => 'test',
            'display_name' => 'Test',
            'description'  => 'Test role',
        ]);

        $resource = $this->actingAs($this->admin)->post('admin/roles/3', [
            '_method'      => 'PUT',
            'display_name' => 'Edited role',
            'description'  => 'Edited role description',
        ]);

        $resource->assertStatus(302);
        $resource->assertRedirect('http://localhost/admin/roles/3/edit');
        $this->assertTrue(Role::find(3)->display_name === 'Edited role');
        $this->assertTrue(Role::find(3)->description === 'Edited role description');
    }

    public function testRoleEditFormContainsUsersDatatable()
    {
        Role::create([
            'name'         => 'test',
            'display_name' => 'Test',
            'description'  => 'Test role',
        ]);

        $resource = $this->actingAs($this->admin)->get('admin/roles/3/edit');
        $resource->assertStatus(200);
        $resource->assertSeeInOrder([
            '<h3 class="card-title">Parameters</h3>',
            '<h3 class="card-title">Users with this role</h3>',
            'id="dt_role_users"',
            'window.dt_role_users_ajax',
            '"role_id":3',
        ], false);
    }

    public function testRoleUsersDatatableReturnsOnlyUsersWithRole()
    {
        $altRole = Role::create([
            'name'         => 'other',
            'display_name' => 'Other',
            'description'  => 'Other role',
        ]);

        $userInRole = UserFactory::create()->backendUser();
        $userInRole->addRole($altRole);
        UserFactory::create()->backendUser();

        $resource = $this->actingAs($this->admin)->post('admin/datatables/role_users', [
            'role_id' => $altRole->id,
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $resource->assertStatus(200);
        $content = $resource->getOriginalContent();

        $this->assertEquals(1, $content['recordsTotal']);
        $this->assertEquals($userInRole->email, $content['data'][0]['email']);
    }

    public function testRoleUsersDatatableDeniedWithoutPermission()
    {
        $resource = $this->actingAs($this->user)->post('admin/datatables/role_users', [
            'role_id' => 1,
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $resource->assertStatus(503);
    }

    public function testRoleDestroy()
    {
        Role::create([
            'name'         => 'test',
            'display_name' => 'Test',
            'description'  => 'Test role',
        ]);

        $this->assertTrue(Role::find(3) !== null);

        $resource = $this->actingAs($this->admin)->post('admin/roles/3', [
            '_method' => 'DELETE',
        ]);

        $resource->assertStatus(200);
        $this->assertTrue(Role::find(3) === null);
        $this->assertTrue($resource->content() === '');
    }
}
