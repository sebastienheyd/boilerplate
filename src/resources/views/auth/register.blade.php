@extends('boilerplate::auth.layout', ['title' => __('boilerplate::auth.register.title'), 'bodyClass' => 'hold-transition login-page'])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg text-sm">{{ __('boilerplate::auth.register.intro') }}</p>
        {!! Form::open(['route' => 'boilerplate.register', 'method' => 'post', 'autocomplete'=> 'off']) !!}
            <div class="mb-3">
                <div class="input-group">
                    {{ Form::text('first_name', old('first_name'), ['class' => 'form-control'.$errors->first('first_name', ' is-invalid'), 'placeholder' => __('boilerplate::auth.fields.first_name'), 'required', 'autofocus']) }}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                {!! $errors->first('first_name','<div class="error-bubble"><div>:message</div></div>') !!}
            </div>
            <div class="mb-3">
                <div class="input-group">
                    {{ Form::text('last_name', old('last_name'), ['class' => 'form-control'.$errors->first('last_name', ' is-invalid'), 'placeholder' => __('boilerplate::auth.fields.last_name'), 'required']) }}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                {!! $errors->first('last_name','<div class="error-bubble"><div>:message</div></div>') !!}
            </div>
            <div class="mb-3">
                <div class="input-group">
                    {{ Form::email('email', old('email'), ['class' => 'form-control'.$errors->first('email', ' is-invalid'), 'placeholder' => __('boilerplate::auth.fields.email'), 'required']) }}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                {!! $errors->first('email','<div class="error-bubble"><div>:message</div></div>') !!}
            </div>
            <div class="mb-3">
                <div class="input-group">
                    {{ Form::password('password', ['class' => 'form-control'.$errors->first('password', ' is-invalid'), 'placeholder' => __('boilerplate::auth.fields.password'), 'required']) }}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                {!! $errors->first('password','<div class="error-bubble"><div>:message</div></div>') !!}
            </div>
            <div class="mb-3">
                <div class="input-group">
                    {{ Form::password('password_confirmation', ['class' => 'form-control'.$errors->first('password_confirmation', ' is-invalid'), 'placeholder' => __('boilerplate::auth.fields.password_confirm'), 'required']) }}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                {!! $errors->first('password_confirmation','<div class="error-bubble"><div>:message</div></div>') !!}
            </div>
            <div class="mb-3">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-primary">
                        {{ __('boilerplate::auth.register.register_button') }}
                    </button>
                </div>
            </div>
        {!! Form::close() !!}
        @if(!$firstUser)
            <p class="mb-0 text-sm">
                <a href="{{ route('boilerplate.login') }}">{{ __('boilerplate::auth.register.login_link') }}</a><br>
            </p>
        @endif
    @endcomponent
@endsection
