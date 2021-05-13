@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::role.title'),
    'subtitle' => __('boilerplate::role.edit.title'),
    'breadcrumb' => [
        __('boilerplate::role.title') => 'boilerplate.roles.index',
        __('boilerplate::role.edit.title')
    ]
])

@section('content')
    {{ Form::open(['route' => ['boilerplate.roles.update', $role->id], 'method' => 'put', 'autocomplete' => 'off']) }}
        <div class="row">
            <div class="col-12 mb-3">
                <a href="{{ route("boilerplate.roles.index") }}" class="btn btn-default" title="@lang('boilerplate::role.list.title')">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        @lang('boilerplate::role.savebutton')
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                @component('boilerplate::card', ['title' => __('boilerplate::role.parameters')])
                    {!! $errors->first('name','<p class="text-danger"><strong>:message</strong></p>') !!}
                    @component('boilerplate::input', ['name' => 'display_name', 'label' => 'boilerplate::role.label', 'value' => $role->display_name])@endcomponent
                    @component('boilerplate::input', ['name' => 'description', 'label' => 'boilerplate::role.description', 'value' => $role->description])@endcomponent
                @endcomponent
            </div>
            @if(count($permissions_categories) > 0)
            <div class="col-md-7">
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
                                            <div class="icheck-primary">
                                            @if($role->id == 1)
                                                <input type="checkbox" checked disabled class="icheck"/>
                                            @else
                                                {{ Form::checkbox('permission['.$permission->id.']', 1, old('permission.'.$permission->id, $role->permissions()->where(['id' => $permission->id])->count()), ['id' => 'permission_'.$permission->id, 'class' => 'icheck']) }}
                                            @endif
                                                <label for="{{ 'permission_'.$permission->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            {{ Form::label('permission_'.$permission->id, $permission->display_name, ['class' => 'mb-0', 'data-toggle' => 'tooltip', 'data-title' => $permission->name]) }}<br />
                                            <small class="text-muted">{{ $permission->description }}</small>
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
    {{ Form::close() }}
@endsection
