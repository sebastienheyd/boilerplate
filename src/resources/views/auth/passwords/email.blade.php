@extends('auth.layout', ['title' => 'Mot de passe oublié', 'bodyClass' => 'hold-transition login-page'])

@section('content')
    <div class="login-box">
        <div class="login-logo">
            {!! config('app.title') !!}
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Saisissez le champ suivant réinitialiser votre mot de passe</p>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            {!! Form::open(['route' => 'password.email', 'method' => 'post', 'autocomplete'=> 'off']) !!}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'E-mail', 'required', 'autofocus']) }}
                    {!! $errors->first('email','<p class="text-danger"><strong>:message</strong></p>') !!}
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                Envoyer le lien de réinitialisation
                            </button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}

            <a href="{{ route('login') }}">S'identifier avec un utilisateur existant</a><br>
        </div>
    </div>

@endsection
