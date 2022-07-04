@extends('boilerplate::auth.layout', [
    'title' => __('boilerplate::auth.login.title'),
    'bodyClass' => 'hold-transition login-page'
])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg text-sm">@lang('boilerplate::auth.login.intro')</p>
        {!! Form::open(['route' => 'boilerplate.login', 'method' => 'post', 'autocomplete'=> 'off']) !!}
        @component('boilerplate::input', ['name' => 'email', 'placeholder' => 'boilerplate::auth.fields.email', 'append-text' => 'fas fa-fw fa-envelope', 'type' => 'email'])@endcomponent
        @component('boilerplate::password', ['name' => 'password', 'placeholder' => 'boilerplate::auth.fields.password', 'check' => false])@endcomponent
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
            @if(config('boilerplate.locale.switch', false))
            <div class="dropdown-wrapper">
                <div class="form-group">
                    {!! Form::open(['route' => 'boilerplate.lang.switch', 'method' => 'post', 'autocomplete'=> 'off']) !!}
                    <select class="form-control form-control-sm" name="lang" onchange="this.form.submit()">
                        @foreach(collect(config('boilerplate.locale.languages'))->map(function($e){return $e['label'];})->toArray() as $lang => $label)
                            <option value="{{ $lang }}" {{ $lang === App::getLocale() ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    {!! Form::close() !!}
                </div>
            </div>
            @endif
        </div>
    @endcomponent
@endsection