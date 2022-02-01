<?php

namespace Sebastienheyd\Boilerplate\Datatables\Admin;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class RolesDatatable extends Datatable
{
    public $slug = 'roles';

    public function datasource()
    {
        $roleModel = config('boilerplate.laratrust.role');

        return $roleModel::with(['permissions', 'users'])->select([
            'roles.id',
            'roles.name',
            'roles.display_name',
            'roles.description',
        ]);
    }

    public function setUp()
    {
        $this->permissions('users_crud')
            ->locale([
                'deleteConfirm' => __('boilerplate::role.list.confirmdelete'),
                'deleteSuccess' => __('boilerplate::role.list.deletesuccess'),
            ])
            ->buttons([])
            ->noSearching()
            ->noOrdering()
            ->order('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Name'))
                ->class('text-nowrap')
                ->data('display_name', function ($role) {
                    return '<strong>'.$role->display_name.'</strong><br><small class="text-muted">'.$role->name.'</small>';
                }),

            Column::add(__('Description'))
                ->class('text-nowrap')
                ->data('description'),

            Column::add(__('boilerplate::role.permissions'))
                ->data('permissions', function ($role) {
                    if ($role->name === 'admin') {
                        return __('boilerplate::role.admin.permissions');
                    }

                    return $role->permissions->implode('display_name', '<br>') ?: '-';
                }),

            Column::add(__('boilerplate::role.list.nbusers'))
                ->data('users', function ($role) {
                    return $role->users->count();
                }),

            Column::add()
                ->width('20px')
                ->actions(function ($role) {
                    $buttons = Button::edit('boilerplate.roles.edit', $role);

                    if ($role->name !== 'admin' &&
                        ! (config('boilerplate.auth.register') &&
                        $role->name === config('boilerplate.auth.register_role')) &&
                        $role->users->count() === 0
                    ) {
                        $buttons .= Button::delete('boilerplate.roles.destroy', $role);
                    }

                    return $buttons;
                }),
        ];
    }
}
