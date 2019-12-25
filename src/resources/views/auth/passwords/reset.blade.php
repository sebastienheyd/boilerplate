@extends('boilerplate::auth.layout', ['title' => __('boilerplate::auth.password_reset.title')])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg text-sm">{{ __('boilerplate::auth.password_reset.intro') }}</p>
        {!! Form::open(['route' => 'boilerplate.password.reset.post', 'method' => 'post', 'autocomplete'=> 'off']) !!}
            {!! Form::hidden('token', $token) !!}
            <div class="form-group">
                <div class="input-group">
                    {{ Form::email('email', old('email', $email), ['class' => 'form-control'.$errors->first('email', ' is-invalid'), 'placeholder' =>  __('boilerplate::auth.fields.email'), 'required', 'autofocus']) }}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                {!! $errors->first('email','<div class="error-bubble"><div>:message</div></div>') !!}
            </div>
            <div class="form-group">
                <div class="input-group">
                    {{ Form::password('password', ['class' => 'form-control'.$errors->first('password', ' is-invalid'), 'placeholder' =>  __('boilerplate::auth.fields.password'), 'required']) }}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                {!! $errors->first('password','<div class="error-bubble"><div>:message</div></div>') !!}
            </div>
            <div class="form-group">
                <div class="input-group">
                    {{ Form::password('password_confirmation', ['class' => 'form-control'.$errors->first('password_confirmation', ' is-invalid'), 'placeholder' =>  __('boilerplate::auth.fields.password_confirm'), 'required']) }}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                {!! $errors->first('password_confirmation','<div class="error-bubble"><div>:message</div></div>') !!}
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-primary" type="submit">{{ __('boilerplate::auth.password_reset.submit') }}</button>
                </div>
            </div>
        {!! Form::close() !!}
    @endcomponent
@endsection
