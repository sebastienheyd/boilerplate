@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::users.title'),
    'subtitle' => __('boilerplate::users.edit.title'),
    'breadcrumb' => [
        __('boilerplate::users.title') => 'boilerplate.users.index',
        __('boilerplate::users.edit.title')
    ]
])

@section('content')
    @component('boilerplate::form', ['method' => 'put', 'route' => ['boilerplate.users.update', $user->id]])
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
            <div class="col-md-6">
                @component('boilerplate::card', ['color' => 'orange'])
                    <div class="d-flex flex-column flex-md-row">
                        <div id="avatar-wrapper">
                            <img src="{{ $user->avatar_url }}" class="avatar-img" alt="avatar" />
                        </div>
                        <div class="mt-3 mt-md-0 pl-md-3">
                            <span class="info-box-text">
                                <p class="mb-0"><strong class="h3">{{ $user->name  }}</strong></p>
                                <p class="">{{ $user->getRolesList() }}</p>
                            </span>
                            <span class="info-box-more">
                                <p>
                                    <a href="mailto:{{ $user->email }}" class="btn btn-default">
                                        <span class="far fa-fw fa-envelope"></span> {{ $user->email }}
                                    </a>
                                </p>
                                <p class="mb-0 text-muted">
                                    {{ __('boilerplate::users.profile.subscribedsince', [
                                        'date' => $user->created_at->isoFormat(__('boilerplate::date.lFdY')),
                                        'since' => $user->created_at->diffForHumans()]) }}
                                </p>
                            </span>
                        </div>
                    </div>
                @endcomponent
                @component('boilerplate::card', ['title' => __('boilerplate::users.informations')])
                    <div class="row">
                        @if(Auth::user()->id !== $user->id)
                        <div class="col-md-6">
                            @component('boilerplate::select2', ['name' => 'active', 'label' => 'boilerplate::users.status', 'minimum-results-for-search' => '-1'])
                                <option value="1" @if (old('active', $user->active) == '1') selected="selected" @endif>@lang('boilerplate::users.active')</option>
                                <option value="0" @if (old('active', $user->active) == '0') selected="selected" @endif>@lang('boilerplate::users.inactive')</option>
                            @endcomponent
                        </div>
                        @endif
                        <div class="col-md-6">
                            @component('boilerplate::input', ['name' => 'email', 'label' => 'boilerplate::users.email', 'value' => $user->email])@endcomponent
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @component('boilerplate::input', ['name' => 'first_name', 'label' => 'boilerplate::users.firstname', 'value' => $user->first_name])@endcomponent
                        </div>
                        <div class="col-md-6">
                            @component('boilerplate::input', ['name' => 'last_name', 'label' => 'boilerplate::users.lastname', 'value' => $user->last_name])@endcomponent
                        </div>
                    </div>
                @endcomponent
            </div>
            <div class="col-md-6">
                @component('boilerplate::card', ['color' => 'teal', 'title' =>__('boilerplate::users.roles')])
                    <table class="table table-sm table-hover">
                        @foreach($roles as $role)
                            @if($role->name !== 'admin' || ($role->name === 'admin' && Auth::user()->hasRole('admin')))
                            <tr>
                                <td style="width:25px">
                                    @if(Auth::user()->id === $user->id && $role->name === 'admin' && Auth::user()->hasRole('admin'))
                                        @component('boilerplate::icheck', ['name' => 'roles['.$role->id.']', 'id' => 'role_'.$role->id, 'checked' => old('roles['.$role->id.']', $user->hasRole($role->name)), 'disabled' => true, 'data' => ['permissions' => $role->permissions->pluck('id')->implode(','), 'admin' => $role->name === 'admin' ? 1 : 0]])@endcomponent
                                        @component('boilerplate::input', ['type' => 'hidden', 'name' => 'roles['.$role->id.']', 'value' => 1])@endcomponent
                                    @else
                                        @component('boilerplate::icheck', ['name' => 'roles['.$role->id.']', 'id' => 'role_'.$role->id, 'checked' => old('roles['.$role->id.']', $user->hasRole($role->name)), 'data' => ['permissions' => $role->permissions->pluck('id')->implode(','), 'admin' => $role->name === 'admin' ? 1 : 0]])@endcomponent
                                    @endif
                                </td>
                                <td>
                                    <div><label for="{{ 'role_'.$role->id }}" class="mb-0">{{ $role->display_name }}</label></div>
                                    <div class="small">{{ $role->description }}</div>
                                    <div class="small text-muted pt-1">{!! $role->permissions->implode('display_name', '<br>') !!}</div>
                                </td>
                            </tr>
                            @endif
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
                                        $isDirect = old('permission.'.$permission->id, $user->permissions->contains('id', $permission->id)) ? 1 : 0;
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