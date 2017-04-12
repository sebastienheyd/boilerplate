@extends('boilerplate::auth.layout', [
    'title' => __('boilerplate::auth.login.title'),
    'bodyClass' => 'hold-transition login-page'
])

@include('boilerplate::load.icheck')

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg">{{ __('boilerplate::auth.login.intro') }}</p>
        {!! Form::open(['route' => 'login', 'method' => 'post', 'autocomplete'=> 'off']) !!}
        <div class="form-group has-feedback">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => __('boilerplate::auth.fields.email'), 'required', 'autofocus']) }}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                {!! $errors->first('email','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
        </div>
        <div class="form-group has-feedback">
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('boilerplate::auth.fields.password')]) }}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                {!! $errors->first('password','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember" class="icheck" {{ old('remember') ? 'checked' : '' }}> {{ __('boilerplate::auth.login.rememberme') }}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mbs">
                <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('boilerplate::auth.login.signin') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
        <a href="{{ route('password.request') }}">{{ __('boilerplate::auth.login.forgotpassword') }}</a><br>
        @if(config('boilerplate.auth.register'))
            <a href="{{ route('register') }}" class="text-center">{{ __('boilerplate::auth.login.register') }}</a>
        @endif
    @endcomponent
@endsection
