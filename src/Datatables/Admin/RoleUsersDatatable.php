<?php

namespace Sebastienheyd\Boilerplate\Datatables\Admin;

use Illuminate\Database\Eloquent\Builder;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class RoleUsersDatatable extends Datatable
{
    public $slug = 'role_users';

    public function datasource()
    {
        $userModel = config('boilerplate.auth.providers.users.model');
        $roleId = (int) request()->input('role_id');

        return $userModel::with('roles')
            ->whereHas('roles', function (Builder $query) use ($roleId) {
                $query->where('roles.id', $roleId);
            })
            ->select([
                'users.id',
                'email',
                'last_name',
                'first_name',
                'active',
                'last_login',
            ]);
    }

    public function setUp()
    {
        $this->permissions('roles_crud')
            ->order('last_name', 'asc')
            ->stateSave();
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->width('40px')
                ->notSearchable()
                ->notOrderable()
                ->data('avatar', function ($user) {
                    return '<img src="'.$user->avatar_url.'" class="img-circle" width="32" height="32" />';
                }),

            Column::add(__('boilerplate::users.list.state'))
                ->width('90px')
                ->data('active', function ($user) {
                    $badge = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($user->active == 1) {
                        return sprintf($badge, 'success', __('boilerplate::users.active'));
                    }

                    return sprintf($badge, 'danger', __('boilerplate::users.inactive'));
                })
                ->filterOptions([__('boilerplate::users.inactive'), __('boilerplate::users.active')]),

            Column::add(__('Last name'))
                ->data('last_name'),

            Column::add(__('First name'))
                ->data('first_name'),

            Column::add(__('Email'))
                ->class('text-nowrap')
                ->data('email'),

            Column::add(__('boilerplate::users.list.lastconnect'))
                ->data('last_login')
                ->fromNow()
                ->dateRangeFilter(),
        ];
    }
}
