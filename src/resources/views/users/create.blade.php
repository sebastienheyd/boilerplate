@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::users.title'),
    'subtitle' => __('boilerplate::users.create.title'),
    'breadcrumb' => [
        __('boilerplate::users.title') => 'boilerplate.users.index',
        __('boilerplate::users.create.title')
    ]
])

@section('content')
    {{ Form::open(['route' => 'boilerplate.users.store', 'autocomplete' => 'off']) }}
        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route("boilerplate.users.index") }}" class="btn btn-default" title="{{ __('boilerplate::users.returntolist') }}">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        {{ __('boilerplate::users.save') }}
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @component('boilerplate::card', ['title' => __('boilerplate::users.informations')])
                    <div class="form-group">
                        {{ Form::label('active', __('boilerplate::users.status')) }}
                        {{ Form::select("active", ['0' => __('boilerplate::users.inactive'), '1' => __('boilerplate::users.active')], old('active', 1), ['class' => 'form-control'.$errors->first('active', ' is-invalid')]) }}
                        {!! $errors->first('active','<div class="error-bubble"><div>:message</div></div>') !!}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('last_name', __('boilerplate::users.lastname')) }}
                                {{ Form::input('text', 'last_name', old('last_name'), ['class' => 'form-control'.$errors->first('last_name', ' is-invalid'), 'autofocus']) }}
                                {!! $errors->first('last_name','<div class="error-bubble"><div>:message</div></div>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('last_name', __('boilerplate::users.firstname')) }}
                                {{ Form::input('text', 'first_name', old('first_name'), ['class' => 'form-control'.$errors->first('first_name', ' is-invalid')]) }}
                                {!! $errors->first('first_name','<div class="error-bubble"><div>:message</div></div>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('email', __('boilerplate::users.email')) }}
                        {{ Form::input('text', 'email', old('email'), ['class' => 'form-control'.$errors->first('email', ' is-invalid')]) }}
                        {!! $errors->first('email','<div class="error-bubble"><div>:message</div></div>') !!}
                        <small class="text-muted">
                            {{ __('boilerplate::users.create.help') }}
                        </small>
                    </div>
                @endcomponent
            </div>
            <div class="col-md-6">
                @component('boilerplate::card', ['color' => 'teal', 'title' =>__('boilerplate::users.roles')])
                    <table class="table table-sm table-hover">
                        @foreach($roles as $role)
                            <tr>
                                <td style="width:25px">
                                    <div class="icheck-primary">
                                        {{ Form::checkbox('roles['.$role->id.']', null, null, ['id' => 'role_'.$role->id]) }}
                                        <label for="{{ 'role_'.$role->id }}"></label>
                                    </div>
                                </td>
                                <td>
                                    {{ Form::label('role_'.$role->id, $role->display_name, ['class' => 'mb-0 pb-0']) }}<br />
                                    <span class="small">{{ $role->description }}</span><br />
                                    <span class="small text-muted">{{ $role->permissions->implode('display_name', ', ') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endcomponent
            </div>
        </div>
    {{ Form::close() }}
@endsection