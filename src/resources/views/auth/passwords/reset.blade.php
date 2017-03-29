@extends('auth.layout', ['title' => 'Réinitialisation du mot de passe', 'bodyClass' => 'hold-transition login-page'])

@section('content')
<div class="login-box">
    <div class="login-logo">
        {!! config('app.title') !!}
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Saisissez les champs suivants pour reinitialiser votre mot de passe</p>
        {!! Form::open(['route' => 'password.reset.post', 'method' => 'post', 'autocomplete'=> 'off']) !!}
            {!! Form::hidden('token', $token) !!}
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::email('email', $email or old('email'), ['class' => 'form-control', 'placeholder' => 'E-mail', 'required', 'autofocus']) }}
                {!! $errors->first('email','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Mot de passe', 'required']) }}
                {!! $errors->first('password','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirmation du mot de passe', 'required']) }}
                {!! $errors->first('password_confirmation','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <button class="btn btn-primary" type="submit">Réinitialiser</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
