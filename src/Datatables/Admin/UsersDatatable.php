<?php

namespace Sebastienheyd\Boilerplate\Datatables\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class UsersDatatable extends Datatable
{
    public $slug = 'users';

    public function datasource()
    {
        $userModel = config('boilerplate.auth.providers.users.model');

        return $userModel::with('roles')->select([
            'users.id',
            'email',
            'last_name',
            'first_name',
            'active',
            'users.created_at',
            'last_login',
        ]);
    }

    public function setUp()
    {
        $this->permissions('users_crud')
            ->locale([
                'deleteConfirm' => __('boilerplate::users.list.confirmdelete'),
                'deleteSuccess' => __('boilerplate::users.list.deletesuccess'),
            ])->order('created_at', 'desc')->stateSave();
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
                ->width('100px')
                ->data('active', function ($user) {
                    $badge = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($user->active == 1) {
                        return sprintf($badge, 'success', __('boilerplate::users.active'));
                    }

                    return sprintf($badge, 'danger', __('boilerplate::users.inactive'));
                })
                ->filterOptions([__('boilerplate::users.inactive'), __('boilerplate::users.active')]),

            Column::add(__('Last name'))
                ->width('12%')
                ->data('last_name'),

            Column::add(__('First name'))
                ->width('12%')
                ->data('first_name'),

            Column::add(__('Email'))
                ->width('12%')
                ->data('email'),

            Column::add(__('boilerplate::users.list.roles'))
                ->notOrderable()
                ->filter(function ($query, $q) {
                    $query->whereHas('roles', function (Builder $query) use ($q) {
                        $query->where('name', '=', $q);
                    });
                })
                ->data('roles', function ($user) {
                    return $user->roles->implode('display_name', ', ') ?: '-';
                })
                ->filterOptions(function () {
                    $roleModel = config('boilerplate.laratrust.role');

                    return $roleModel::all()->pluck('display_name', 'name')->toArray();
                }),

            Column::add(__('Created at'))
                ->width('12%')
                ->data('created_at')
                ->name('users.created_at')
                ->dateFormat(),

            Column::add(__('boilerplate::users.list.lastconnect'))
                ->width('12%')
                ->data('last_login')
                ->fromNow(),

            Column::add()
                ->width('70px')
                ->actions(function ($user) {
                    $currentUser = Auth::user();

                    $buttons = Button::edit('boilerplate.users.edit', $user->id);

                    if (($currentUser->hasRole('admin') || ! $user->hasRole('admin')) && $user->id !== $currentUser->id) {
                        $buttons .= Button::delete('boilerplate.users.destroy', $user->id);
                    }

                    return $buttons;
                }),
        ];
    }
}
