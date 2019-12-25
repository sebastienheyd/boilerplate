@extends('boilerplate::auth.layout', [
    'title' => __('boilerplate::auth.firstlogin.title'),
    'bodyClass' => 'hold-transition login-page'
])

@section('content')
    @component('boilerplate::auth.loginbox')
        {{ Form::open(['route' => 'boilerplate.users.firstlogin', 'autocomplete' => 'off']) }}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="alert alert-info">
            {{ __('boilerplate::auth.firstlogin.intro') }}
        </div>
        <div class="form-group">
            <div class="input-group">
                {{ Form::input('password', 'password', Request::old('password'), ['class' => 'form-control'.$errors->first('password', ' is-invalid'), 'autofocus', 'placeholder' => __('boilerplate::auth.fields.password')]) }}
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            {!! $errors->first('password','<div class="error-bubble"><div>:message</div></div>') !!}
        </div>
        <div class="form-group">
            <div class="input-group">
                {{ Form::input('password', 'password_confirmation', Request::old('password_confirmation'), ['class' => 'form-control'.$errors->first('password_confirmation', ' is-invalid'), 'placeholder' => __('boilerplate::auth.fields.password_confirm')]) }}
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            {!! $errors->first('password_confirmation','<div class="error-bubble"><div>:message</div></div>') !!}
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">
                {{ __('boilerplate::auth.firstlogin.button') }}
            </button>
        </div>
        </form>
    @endcomponent
@endsection
