@extends('auth.layout', ['title' => 'Connexion', 'bodyClass' => 'hold-transition login-page'])

@include('load.icheck')

@section('content')
    @component('auth.loginbox')
        <p class="login-box-msg">Identifiez vous pour démarrer une session</p>

        {!! Form::open(['route' => 'login', 'method' => 'post', 'autocomplete'=> 'off']) !!}
        <div class="form-group has-feedback">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'E-mail', 'required', 'autofocus']) }}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                {!! $errors->first('email','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
        </div>
        <div class="form-group has-feedback">
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Mot de passe']) }}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                {!! $errors->first('password','<p class="text-danger"><strong>:message</strong></p>') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember" class="icheck" {{ old('remember') ? 'checked' : '' }}> Se souvenir de moi
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mbs">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Connexion</button>
            </div>
        </div>
        {!! Form::close() !!}

        <a href="{{ route('password.request') }}">J'ai oublié mon mot de passe</a><br>
        <a href="{{ route('register') }}" class="text-center">Créer un nouveau compte</a>
    @endcomponent
@endsection
