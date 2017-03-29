@extends('auth.layout', ['title' => 'Créer un nouveau compte', 'bodyClass' => 'hold-transition login-page'])

@section('content')
    <div class="login-box">
        <div class="login-logo">
            {!! config('app.title') !!}
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Saisissez les champs suivants pour créer un nouvel utilisateur</p>
            {!! Form::open(['route' => 'register', 'method' => 'post', 'autocomplete'=> 'off']) !!}
                <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                    {{ Form::text('lastname', old('lastname'), ['class' => 'form-control', 'placeholder' => 'Nom', 'required', 'autofocus']) }}
                    {!! $errors->first('lastname','<p class="text-danger"><strong>:message</strong></p>') !!}
                </div>
                <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
                    {{ Form::text('firstname', old('firstname'), ['class' => 'form-control', 'placeholder' => 'Prénom', 'required', 'autofocus']) }}
                    {!! $errors->first('firstname','<p class="text-danger"><strong>:message</strong></p>') !!}
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'E-mail', 'required']) }}
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
                <div class="row mbm">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            Créer
                        </button>
                    </div>
                </div>
            {!! Form::close() !!}

            @if(!$firstUser)
                <a href="{{ route('login') }}">S'identifier avec un utilisateur existant</a><br>
            @endif
        </div>
    </div>
@endsection
