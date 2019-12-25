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
                <a href="{{ route("boilerplate.roles.index") }}" class="btn btn-default" title="{{ __('boilerplate::role.list.title') }}">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        {{ __('boilerplate::role.savebutton') }}
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('boilerplate::role.parameters') }}</h3>
                    </div>
                    <div class="card-body">
                        {!! $errors->first('name','<p class="text-danger"><strong>:message</strong></p>') !!}
                        <div class="form-group">
                            {{ Form::label('display_name', __('boilerplate::role.label')) }}
                            {{ Form::text('display_name', old('display_name', $role->display_name), ['class' => 'form-control'.$errors->first('display_name', ' is-invalid'), 'autofocus']) }}
                            {!! $errors->first('display_name','<div class="error-bubble"><div>:message</div></div>') !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('description', __('boilerplate::role.description')) }}
                            {{ Form::text('description', old('description', $role->description), ['class' => 'form-control'.$errors->first('description', ' is-invalid')]) }}
                            {!! $errors->first('description','<div class="error-bubble"><div>:message</div></div>') !!}
                        </div>
                    </div>
                </div>
            </div>
            @if(count($permissions) > 0)
            <div class="col-md-7">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('boilerplate::role.permissions') }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-sm">
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td style="width:25px;">
                                        <div class="icheck-primary">
                                        @if($role->id == 1)
                                            <input type="checkbox" checked disabled class="icheck"/>
                                        @else
                                            {{ Form::checkbox('permission['.$permission->id.']', 1, old('permission['.$permission->id.']', $role->permissions()->where(['id' => $permission->id])->count()), ['id' => 'permission_'.$permission->id, 'class' => 'icheck']) }}
                                        @endif
                                            <label for="{{ 'permission_'.$permission->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ Form::label('permission_'.$permission->id, $permission->display_name, ['class' => 'mb-0']) }}<br />
                                        <small>{{ $permission->description }}</small>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
    {{ Form::close() }}
@endsection