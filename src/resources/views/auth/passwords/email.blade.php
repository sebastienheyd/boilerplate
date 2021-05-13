@extends('boilerplate::auth.layout', ['title' => __('boilerplate::auth.password.title'), 'bodyClass' => 'hold-transition login-page'])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg text-sm">@lang('boilerplate::auth.password.intro')</p>
        @if (session('status'))
            <div class="alert alert-success d-flex align-items-center">
                <span class="far fa-check-circle fa-3x mr-3"></span>
                {{ session('status') }}
            </div>
        @else
            {!! Form::open(['route' => 'boilerplate.password.email', 'method' => 'post', 'autocomplete'=> 'off']) !!}
                @component('boilerplate::input', ['name' => 'email', 'placeholder' => 'boilerplate::auth.fields.email', 'append-text' => 'fas fa-envelope', 'type' => 'email', 'autofocus' => true])@endcomponent
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary">@lang('boilerplate::auth.password.submit')</button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        @endif
        <p class="mb-0 text-sm">
            <a href="{{ route('boilerplate.login') }}">@lang('boilerplate::auth.password.login_link')</a>
        </p>
        @if(config('boilerplate.auth.register'))
            <p class="mb-0 text-sm">
                <a href="{{ route('boilerplate.register') }}" class="text-center">@lang('boilerplate::auth.login.register')</a>
            </p>
        @endif
    @endcomponent
@endsection
