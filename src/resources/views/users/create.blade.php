@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::users.title'),
    'subtitle' => __('boilerplate::users.create.title'),
    'breadcrumb' => [
        __('boilerplate::users.title') => 'boilerplate.users.index',
        __('boilerplate::users.create.title')
    ]
])

@section('content')
    @component('boilerplate::form', ['route' => 'boilerplate.users.store'])
        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route("boilerplate.users.index") }}" class="btn btn-default" data-toggle="tooltip" title="@lang('boilerplate::users.returntolist')">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        @lang('boilerplate::users.save')
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'boilerplate::users.informations'])
                    @component('boilerplate::select2', ['name' => 'active', 'label' => 'boilerplate::users.status', 'minimum-results-for-search' => '-1'])
                        <option value="1" @if (old('active', 1) == '1') selected="selected" @endif>@lang('boilerplate::users.active')</option>
                        <option value="0" @if (old('active') == '0') selected="selected" @endif>@lang('boilerplate::users.inactive')</option>
                    @endcomponent
                    <div class="row">
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            @component('boilerplate::input', ['name' => 'first_name', 'label' => 'boilerplate::users.firstname', 'autofocus' => true])@endcomponent
                        </div>
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            @component('boilerplate::input', ['name' => 'last_name', 'label' => 'boilerplate::users.lastname'])@endcomponent
                        </div>
                    </div>
                    @component('boilerplate::input', ['name' => 'email', 'label' => 'boilerplate::users.email', 'help' => 'boilerplate::users.create.help'])@endcomponent
                @endcomponent
            </div>
            <div class="col-lg-6">
                @component('boilerplate::card', ['color' => 'teal', 'title' => 'boilerplate::users.roles'])
                    <table class="table table-sm table-hover">
                        @foreach($roles as $role)
                            <tr>
                                <td style="width:25px">
                                    @component('boilerplate::icheck', ['name' => 'roles['.$role->id.']', 'id' => 'role_'.$role->id, 'checked' => old('roles.'.$role->id) == 'on', 'data' => ['permissions' => $role->permissions->pluck('id')->implode(','), 'admin' => $role->name === 'admin' ? 1 : 0]])@endcomponent
                                </td>
                                <td>
                                    <label for="{{ 'role_'.$role->id }}" class="mb-0">{{ $role->display_name }}</label><br>
                                    <span class="small">{{ $role->description }}</span><br>
                                    <span class="small text-muted">{!! $role->permissions->implode('display_name', '<br>') !!}</span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endcomponent
                @if(count($permissions_categories) > 0)
                @component('boilerplate::card', ['color' => 'indigo', 'title' => __('boilerplate::users.permissions')])
                    @foreach($permissions_categories as $category)
                        <div class="permission_category">
                            <div class="h6">
                                {{ $category->name }}
                            </div>
                            <table class="table table-hover table-sm">
                                <tbody>
                                @foreach($category->permissions as $permission)
                                    @php
                                        $isDirect = old('permission.'.$permission->id, false) ? 1 : 0;
                                    @endphp
                                    <tr>
                                        <td style="width:25px;">
                                            @component('boilerplate::icheck', ['name' => 'permission['.$permission->id.']', 'id' => 'permission_'.$permission->id, 'checked' => (bool) $isDirect, 'data' => ['direct' => $isDirect]])@endcomponent
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
                @endif
            </div>
        </div>
    @endcomponent
    @include('boilerplate::users._permissions-script')
@endsection