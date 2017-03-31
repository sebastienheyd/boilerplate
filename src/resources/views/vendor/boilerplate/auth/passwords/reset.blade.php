@extends('boilerplate::auth.layout', ['title' => __('boilerplate::auth.password_reset.title')])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg">{{ __('boilerplate::auth.password_reset.intro') }}</p>
        {!! Form::open(['route' => 'password.reset.post', 'method' => 'post', 'autocomplete'=> 'off']) !!}
            {!! Form::hidden('token', $token) !!}
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::email('email', $email or old('email'), ['class' => 'form-control', 'placeholder' =>  __('boilerplate::auth.fields.email'), 'required', 'autofocus']) }}
                {!! $errors->first('email','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' =>  __('boilerplate::auth.fields.password'), 'required']) }}
                {!! $errors->first('password','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' =>  __('boilerplate::auth.fields.password_confirm'), 'required']) }}
                {!! $errors->first('password_confirmation','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <button class="btn btn-primary" type="submit">{{ __('boilerplate::auth.password_reset.submit') }}</button>
                </div>
            </div>
        {!! Form::close() !!}
    @endcomponent
@endsection
