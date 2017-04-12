@extends('boilerplate::auth.layout', ['title' => __('boilerplate::register.title'), 'bodyClass' => 'hold-transition login-page'])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg">{{ __('boilerplate::auth.register.intro') }}</p>
        {!! Form::open(['route' => 'register', 'method' => 'post', 'autocomplete'=> 'off']) !!}
            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                {{ Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => __('boilerplate::auth.fields.last_name'), 'required', 'autofocus']) }}
                {!! $errors->first('last_name','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => __('boilerplate::auth.fields.first_name'), 'required']) }}
                {!! $errors->first('first_name','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => __('boilerplate::auth.fields.email'), 'required']) }}
                {!! $errors->first('email','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('boilerplate::auth.fields.password'), 'required']) }}
                {!! $errors->first('password','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => __('boilerplate::auth.fields.password_confirm'), 'required']) }}
                {!! $errors->first('password_confirmation','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="row mbm">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <button type="submit" class="btn btn-primary">
                        {{ __('boilerplate::auth.register.register_button') }}
                    </button>
                </div>
            </div>
        {!! Form::close() !!}
        @if(!$firstUser)
            <a href="{{ route('login') }}">{{ __('boilerplate::auth.register.login_link') }}</a><br>
        @endif
    @endcomponent
@endsection
