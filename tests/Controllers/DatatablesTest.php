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
        $this->assertEquals('<a href="/admin/users/1/edit" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary ml-1" data-action="dt-edit-element"><i class="fas fa-fw fa-pencil-alt"></i></a>', $data['dt-actions']);
    }

    public function testUsersDatatablesShowsDirectPermissions()
    {
        $admin = UserFactory::create()->admin(true);
        $userWithDirect = UserFactory::create()->backendUser();
        $userWithRoleOnly = UserFactory::create()->backendUser();

        // Attach two direct permissions to userWithDirect (ids 2 = users_crud, 3 = roles_crud).
        $userWithDirect->permissions()->sync([2, 3]);

        $resource = $this->post('admin/datatables/users', [], [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $data = collect($resource->getOriginalContent()['data'])
            ->keyBy('email');

        $this->assertStringContainsString(
            'User management',
            $data[$userWithDirect->email]['permissions']
        );
        $this->assertStringContainsString(
            'Role and permissions management',
            $data[$userWithDirect->email]['permissions']
        );

        // Role-inherited permissions must not leak into this column.
        $this->assertEquals('-', $data[$userWithRoleOnly->email]['permissions']);

        // Admin has no direct permissions either (only the admin role).
        $this->assertEquals('-', $data[$admin->email]['permissions']);
    }

    public function testUsersDatatablesFiltersByDirectPermission()
    {
        UserFactory::create()->admin(true);
        $matching = UserFactory::create()->backendUser();
        $other = UserFactory::create()->backendUser();
        $roleInheritedOnly = UserFactory::create()->backendUser();

        $matching->permissions()->sync([2]);  // users_crud as direct permission
        $other->permissions()->sync([3]);     // roles_crud as direct permission
        // roleInheritedOnly has no direct permissions.

        $columnIndex = $this->permissionsColumnIndex();

        $payload = [
            'columns' => [],
        ];
        // yajra/laravel-datatables expects all columns declared in the payload.
        // We pre-fill empty entries up to the permissions column.
        for ($i = 0; $i <= $columnIndex; $i++) {
            $payload['columns'][$i] = [
                'data'       => (string) $i,
                'name'       => '',
                'searchable' => 'true',
                'orderable'  => 'true',
                'search'     => ['value' => '', 'regex' => 'false'],
            ];
        }
        // Set the permission filter value: filter by permission name 'users_crud'.
        $payload['columns'][$columnIndex]['data'] = 'permissions';
        $payload['columns'][$columnIndex]['search']['value'] = 'users_crud';

        $resource = $this->post('admin/datatables/users', $payload, [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $emails = collect($resource->getOriginalContent()['data'])->pluck('email')->all();

        $this->assertContains($matching->email, $emails);
        $this->assertNotContains($other->email, $emails);
        $this->assertNotContains($roleInheritedOnly->email, $emails);
    }

    /**
     * Resolve the zero-based index of the Permissions column in UsersDatatable.
     * Reading it from the datatable itself prevents the test from breaking on
     * future column reorderings.
     */
    private function permissionsColumnIndex(): int
    {
        $datatable = new \Sebastienheyd\Boilerplate\Datatables\Admin\UsersDatatable();
        $datatable->setUp();

        foreach ($datatable->getColumns() as $index => $column) {
            if ($column->data === 'permissions') {
                return $index;
            }
        }

        $this->fail('Permissions column not found in UsersDatatable');
    }
}
