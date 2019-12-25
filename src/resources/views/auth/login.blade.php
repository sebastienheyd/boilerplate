@extends('boilerplate::auth.layout', [
    'title' => __('boilerplate::auth.login.title'),
    'bodyClass' => 'hold-transition login-page'
])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg text-sm">{{ __('boilerplate::auth.login.intro') }}</p>
        {!! Form::open(['route' => 'boilerplate.login', 'method' => 'post', 'autocomplete'=> 'off']) !!}
        <div class="form-group">
            <div class="input-group">
                {{ Form::email('email', old('email'), ['class' => 'form-control'.$errors->first('email', ' is-invalid'), 'placeholder' => __('boilerplate::auth.fields.email'), 'required', 'autofocus']) }}
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
                {{ Form::password('password', ['class' => 'form-control'.$errors->first('password', ' is-invalid'), 'placeholder' => __('boilerplate::auth.fields.password'), 'required']) }}
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            {!! $errors->first('password','<div class="error-bubble"><div>:message</div></div>') !!}
        </div>
        <div class="row mb-3">
            <div class="col-7">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="font-weight-normal text-sm">
                        {{ __('boilerplate::auth.login.rememberme') }}
                    </label>
                </div>
            </div>
            <div class="col-5">
                <button type="submit" class="btn btn-primary btn-block">{{ __('boilerplate::auth.login.signin') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
        <p class="mb-1 text-sm">
            <a href="{{ route('boilerplate.password.request') }}">{{ __('boilerplate::auth.login.forgotpassword') }}</a><br>
        </p>
        @if(config('boilerplate.auth.register'))
            <p class="mb-0 text-sm">
                <a href="{{ route('boilerplate.register') }}" class="text-center">{{ __('boilerplate::auth.login.register') }}</a>
            </p>
        @endif
    @endcomponent
@endsection
