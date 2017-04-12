@extends('boilerplate::auth.layout', ['title' => __('boilerplate::auth.password.title'), 'bodyClass' => 'hold-transition login-page'])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg">{{ __('boilerplate::auth.password.intro') }}</p>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        {!! Form::open(['route' => 'password.email', 'method' => 'post', 'autocomplete'=> 'off']) !!}
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => __('boilerplate::auth.fields.email'), 'required', 'autofocus']) }}
                {!! $errors->first('email','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('boilerplate::auth.password.submit') }}
                        </button>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        <a href="{{ route('login') }}">{{ __('boilerplate::auth.password.login_link') }}</a><br>
    @endcomponent
@endsection
