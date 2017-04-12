@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::users.title'),
    'subtitle' => __('boilerplate::users.create.title'),
    'breadcrumb' => [
        __('boilerplate::users.title') => 'users.index',
        __('boilerplate::users.create.title')
    ]
])

@include('boilerplate::load.icheck')

@section('content')
    {{ Form::open(['route' => 'users.store', 'autocomplete' => 'off']) }}
        <div class="row">
            <div class="col-sm-12 mbl">
                <a href="{{ route("users.index") }}" class="btn btn-default">
                    {{ __('boilerplate::users.returntolist') }}
                </a>
                <span class="btn-group pull-right">
                    <button type="submit" class="btn btn-primary">
                        {{ __('boilerplate::users.save') }}
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('boilerplate::users.informations') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                            {{ Form::label('active', __('boilerplate::users.status')) }}
                            {{ Form::select("active", ['0' => __('boilerplate::users.inactive'), '1' => __('boilerplate::users.active')], old('active', 1), ['class' => 'form-control']) }}
                            {!! $errors->first('active','<p class="text-danger"><strong>:message</strong></p>') !!}
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                    {{ Form::label('last_name', __('boilerplate::users.lastname')) }}
                                    {{ Form::input('text', 'last_name', old('last_name'), ['class' => 'form-control', 'autofocus']) }}
                                    {!! $errors->first('last_name','<p class="text-danger"><strong>:message</strong></p>') !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                    {{ Form::label('last_name', __('boilerplate::users.firstname')) }}
                                    {{ Form::input('text', 'first_name', old('first_name'), ['class' => 'form-control']) }}
                                    {!! $errors->first('first_name','<p class="text-danger"><strong>:message</strong></p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            {{ Form::label('email', __('boilerplate::users.email')) }}
                            {{ Form::input('text', 'email', old('email'), ['class' => 'form-control']) }}
                            {!! $errors->first('email','<p class="text-danger"><strong>:message</strong></p>') !!}
                            <small class="text-muted">
                                {{ __('boilerplate::users.create.help') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('boilerplate::users.roles') }}</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-condensed table-hover">
                            @foreach($roles as $role)
                                <tr>
                                    <td style="width:25px">
                                        {{ Form::checkbox('roles['.$role->id.']', null, null, ['id' => 'role_'.$role->id, 'class' => 'icheck']) }}
                                    </td>
                                    <td>
                                        {{ Form::label('role_'.$role->id, $role->display_name, ['class' => 'mbn']) }}<br />
                                        <span class="small">{{ $role->description }}</span><br />
                                        <span class="small text-muted">{{ $role->permissions->implode('display_name', ', ') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection