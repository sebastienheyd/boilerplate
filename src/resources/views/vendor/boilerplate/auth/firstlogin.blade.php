@extends('boilerplate::auth.layout', [
    'title' => __('boilerplate::auth.login.title'),
    'bodyClass' => 'hold-transition login-page'
])

@section('content')
    @component('boilerplate::auth.loginbox')
        {{ Form::open(['route' => 'users.firstlogin', 'autocomplete' => 'off']) }}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="alert alert-info">
            <p>
                Ceci est votre première connexion, merci de saisir un mot de passe pour activer votre compte.
            </p>
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            {{ Form::label('password', 'Mot de passe') }}
            {{ Form::input('password', 'password', Request::old('password'), ['class' => 'form-control', 'autofocus']) }}
            {!! $errors->first('password','<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            {{ Form::label('password_confirmation', 'Confirmation du mot de passe') }}
            {{ Form::input('password', 'password_confirmation', Request::old('password_confirmation'), ['class' => 'form-control']) }}
            {!! $errors->first('password_confirmation','<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">
                Connexion
            </button>
        </div>
        </form>
    @endcomponent
@endsection
