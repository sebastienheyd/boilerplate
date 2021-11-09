<?php

namespace Sebastienheyd\Boilerplate\Datatables;

use Illuminate\Support\Facades\Auth;

class UsersDatatable extends Datatable
{
    public $slug = 'users';

    public function datasource()
    {
        $userModel = config('boilerplate.auth.providers.users.model');
        return $userModel::with('roles')->select(['id', 'last_name', 'first_name', 'active']);
    }

    public function setUp()
    {

    }

    public function columns(): array
    {
        return [
            Column::add('Id')
                ->field('id')
                ->hidden()
                ->notSearchable(),

            Column::add()
                ->width('40px')
                ->notSearchable()
                ->notOrderable()
                ->raw('avatar', function ($user) {
                    return '<img src="'.$user->avatar_url.'" class="img-circle" width="32" height="32" />';
                }),

            Column::add('Statut')
                ->width('100px')
                ->raw('active', function ($user) {
                    if ($user->active == 1) {
                        return '<span class="badge badge-pill badge-success">'.__('boilerplate::users.active').'</span>';
                    }

                    return '<span class="badge badge-pill badge-danger">'.__('boilerplate::users.inactive').'</span>';
                }),

            Column::add(__('boilerplate::users.list.lastname'))
                ->field('last_name'),

            Column::add(__('boilerplate::users.list.firstname'))
                ->field('first_name'),

            Column::add('Roles')
                ->notOrderable()
                ->raw('roles.name', function ($user) {
                    return $user->getRolesList();
                }),

            Column::add()
                ->class('visible-on-hover text-nowrap')
                ->notSearchable()
                ->notOrderable()
                ->raw('actions', function ($user) {
                    $currentUser = Auth::user();

                    // Admin can edit and delete anyone...
                    if ($currentUser->hasRole('admin')) {
                        $b = $this->button(route('boilerplate.users.edit', $user->id), 'primary mr-1', 'pencil-alt');

                        // ...except delete himself
                        if ($user->id !== $currentUser->id) {
                            $b .= $this->button(route('boilerplate.users.destroy', $user->id),
                                'danger destroy',
                                'trash');
                        }

                        return $b;
                    }

                    // The user is the current user, you can't delete yourself
                    if ($user->id === $currentUser->id) {
                        return $this->button(route('boilerplate.users.edit', $user->id), 'primary mr-1', 'pencil');
                    }

                    $b = $this->button(route('boilerplate.users.edit', $user->id), 'primary mr1', 'pencil');

                    // Current user is not admin, only admin can delete another admin
                    if (! $user->hasRole('admin')) {
                        $b .= $this->button(route('boilerplate.users.destroy', $user->id), 'danger destroy', 'trash');
                    }

                    return $b;
                }),
        ];
    }

    protected function button(string $route, string $class, string $icon): string
    {
        $str = '<a href="%s" class="btn btn-sm btn-%s"><i class="fa fa-fw fa-%s"></i></a>';

        return sprintf($str, $route, $class, $icon);
    }
}