@extends('boilerplate::auth.layout', [
    'title' => __('boilerplate::auth.login.title'),
    'bodyClass' => 'hold-transition login-page'
])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg text-sm">@lang('boilerplate::auth.login.intro')</p>
        {!! Form::open(['route' => 'boilerplate.login', 'method' => 'post', 'autocomplete'=> 'off']) !!}
        @component('boilerplate::input', ['name' => 'email', 'placeholder' => 'boilerplate::auth.fields.email', 'append-text' => 'fas fa-envelope', 'type' => 'email'])@endcomponent
        @component('boilerplate::input', ['name' => 'password', 'placeholder' => 'boilerplate::auth.fields.password', 'append-text' => 'fas fa-lock', 'type' => 'password'])@endcomponent
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            @component('boilerplate::icheck', ['name' => 'remember', 'checked' => old('remember') == 'on', 'label' => 'boilerplate::auth.login.rememberme', 'class' => 'text-sm'])@endcomponent
            <button type="submit" class="btn btn-primary mb-3">@lang('boilerplate::auth.login.signin')</button>
        </div>
        {!! Form::close() !!}
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <p class="mb-1 text-sm">
                    <a href="{{ route('boilerplate.password.request') }}">@lang('boilerplate::auth.login.forgotpassword')</a><br>
                </p>
                @if(config('boilerplate.auth.register'))
                    <p class="mb-0 text-sm">
                        <a href="{{ route('boilerplate.register') }}" class="text-center">@lang('boilerplate::auth.login.register')</a>
                    </p>
                @endif
            </div>
            @if(config('boilerplate.locale.switcher', false))
            <div class="dropdown-wrapper">
                <div class="form-group">
                    <select class="form-control form-control-sm" onchange="if (this.value) window.location.href=this.value">
                        @foreach(config('boilerplate.locale.allowed') as $lang)
                            <option value="{{ route('boilerplate.lang.switch', $lang) }}" {{ $lang === App::getLocale() ? 'selected' : '' }}>{{ config('boilerplate.locale.languages.'.$lang) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
        </div>
    @endcomponent
@endsection
