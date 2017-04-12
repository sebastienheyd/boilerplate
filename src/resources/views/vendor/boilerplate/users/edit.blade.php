@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::users.title'),
    'subtitle' => __('boilerplate::users.edit.title'),
    'breadcrumb' => [
        __('boilerplate::users.title') => 'users.index',
        __('boilerplate::users.edit.title')
    ]
])

@section('content')
    {{ Form::open(['route' => ['users.update', $user->id], 'method' => 'put', 'autocomplete' => 'off']) }}
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
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('boilerplate::users.informations') }}</h3>
                    </div>
                    <div class="box-body">
                        @if(Auth::user()->id !== $user->id)
                            <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                                {{ Form::label('active', __('boilerplate::users.status')) }}
                                {{ Form::select('active', ['0' => __('boilerplate::users.inactive'), '1' => __('boilerplate::users.active')], old('active', $user->active), ['class' => 'form-control']) }}
                                {!! $errors->first('active','<p class="text-danger"><strong>:message</strong></p>') !!}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                    {{ Form::label('last_name', __('boilerplate::users.lastname')) }}
                                    {{ Form::text('last_name', old('last_name', $user->last_name), ['class' => 'form-control', 'autofocus']) }}
                                    {!! $errors->first('last_name','<p class="text-danger"><strong>:message</strong></p>') !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                    {{ Form::label('first_name', __('boilerplate::users.firstname')) }}
                                    {{ Form::text('first_name', old('first_name', $user->first_name), ['class' => 'form-control']) }}
                                    {!! $errors->first('first_name','<p class="text-danger"><strong>:message</strong></p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            {{ Form::label('email', __('boilerplate::users.email')) }}
                            {{ Form::email('email', old('email', $user->email), ['class' => 'form-control']) }}
                            {!! $errors->first('email','<p class="text-danger"><strong>:message</strong></p>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('boilerplate::users.roles') }}</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-condensed table-hover">
                            @foreach($roles as $role)
                                @if($role->name !== 'admin' or ($role->name === 'admin' && Auth::user()->hasRole('admin')))
                                <tr>
                                    <td style="width:25px">
                                        @if(Auth::user()->id === $user->id && $role->name === 'admin' && Auth::user()->hasRole('admin'))
                                            {{ Form::checkbox('roles['.$role->id.']', 1, old('roles['.$role->id.']', $user->hasRole($role->name)), ['id' => 'role_'.$role->id, 'class' => 'icheck', 'checked', 'disabled']) }}
                                            {!! Form::hidden('roles['.$role->id.']', '1', ['id' => 'role_'.$role->id]) !!}
                                        @else
                                            {{ Form::checkbox('roles['.$role->id.']', 1, old('roles['.$role->id.']', $user->hasRole($role->name)), ['id' => 'role_'.$role->id, 'class' => 'icheck']) }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ Form::label('role_'.$role->id, $role->display_name, ['class' => 'mbn']) }}<br />
                                        <span class="small">{{ $role->description }}</span><br />
                                        <span class="small text-muted">{{ $role->permissions->implode('display_name', ', ') }}</span>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection

@include('boilerplate::load.icheck')