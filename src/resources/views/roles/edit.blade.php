@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::role.title'),
    'subtitle' => __('boilerplate::role.edit.title'),
    'breadcrumb' => [
        __('boilerplate::role.title') => 'boilerplate.roles.index',
        __('boilerplate::role.edit.title')
    ]
])

@section('content')
    <style>
        #dt_role_users tbody td { vertical-align: middle; }
        .role-edit-layout { display: flex; flex-direction: column; }
        .role-edit-layout .role-edit-left { display: contents; }
        .role-edit-layout .role-edit-params { order: 1; }
        .role-edit-layout .role-edit-permissions { order: 2; }
        .role-edit-layout .role-edit-users { order: 3; }
        @media (min-width: 1200px) {
            .role-edit-layout { flex-direction: row; align-items: flex-start; column-gap: 1.5rem; }
            .role-edit-layout .role-edit-left { display: flex; flex-direction: column; flex: 1 1 0; min-width: 0; }
            .role-edit-layout .role-edit-permissions { flex: 1 1 0; min-width: 0; order: 0; }
            .role-edit-layout .role-edit-params,
            .role-edit-layout .role-edit-users { order: 0; }
        }
    </style>
    @component('boilerplate::form', ['route' => ['boilerplate.roles.update', $role->id], 'method' => 'put'])
        <div class="row">
            <div class="col-12 mb-3">
                <a href="{{ route("boilerplate.roles.index") }}" class="btn btn-default" title="@lang('boilerplate::role.list.title')">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
                @if($role->name !== 'admin')
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        @lang('boilerplate::role.savebutton')
                    </button>
                </span>
                @endif
            </div>
        </div>
        <div class="role-edit-layout">
            <div class="role-edit-left">
                <div class="role-edit-params">
                    @component('boilerplate::card', ['title' => __('boilerplate::role.parameters')])
                        {!! $errors->first('name','<p class="text-danger"><strong>:message</strong></p>') !!}
                        @if($role->name === 'admin' || $role->name === 'backend_user')
                            <p><strong>@lang('boilerplate::role.label')</strong><br>{{ $role->display_name }}</p>
                            <p><strong>@lang('boilerplate::role.description')</strong><br>{{ $role->description }}</p>
                            @component('boilerplate::input', ['type' => 'hidden', 'name' => 'display_name', 'value' => $role->getAttributes()['display_name']])@endcomponent
                            @component('boilerplate::input', ['type' => 'hidden', 'name' => 'description', 'value' => $role->getAttributes()['description'] ])@endcomponent
                        @else
                            @component('boilerplate::input', ['name' => 'display_name', 'label' => 'boilerplate::role.label', 'value' => $role->display_name])@endcomponent
                            @component('boilerplate::input', ['name' => 'description', 'label' => 'boilerplate::role.description', 'value' => $role->description])@endcomponent
                        @endif
                    @endcomponent
                </div>
                <div class="role-edit-users">
                    @component('boilerplate::card', ['color' => 'orange', 'title' => __('boilerplate::role.users.title')])
                        <x-boilerplate::datatable name="role_users" :ajax="['role_id' => $role->id]" />
                    @endcomponent
                </div>
            </div>
            @if(count($permissions_categories) > 0)
            <div class="role-edit-permissions">
                @component('boilerplate::card', ['color' => 'teal', 'title' => __('boilerplate::role.permissions')])
                    @foreach($permissions_categories as $category)
                        <div class="permission_category">
                            <div class="h6">
                                {{ $category->name }}
                            </div>
                            <table class="table table-hover table-sm">
                                <tbody>
                                @foreach($category->permissions as $permission)
                                    <tr>
                                        <td style="width:25px;">
                                            @if($role->id === 1)
                                                @component('boilerplate::icheck', ['checked' => true, 'disabled' => true])@endcomponent
                                            @else
                                                @component('boilerplate::icheck', ['name' => 'permission['.$permission->id.']', 'id' => 'permission_'.$permission->id, 'checked' => old('permission.'.$permission->id, $role->permissions()->where(['id' => $permission->id])->count())])@endcomponent
                                            @endif
                                        </td>
                                        <td>
                                            <label for="{{ 'permission_'.$permission->id }}" class="mb-0">{{ $permission->display_name }}</label><br>
                                            <small class="text-muted">{{ $permission->description }}</small>
                                        </td>
                                        <td class="text-right visible-on-hover">
                                            <span class="badge badge-secondary badge-pill">{{ $permission->name }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @endcomponent
            </div>
            @endif
        </div>
    @endcomponent
@endsection
