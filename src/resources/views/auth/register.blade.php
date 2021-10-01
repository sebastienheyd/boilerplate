@extends('boilerplate::auth.layout', ['title' => __('boilerplate::auth.register.title'), 'bodyClass' => 'hold-transition login-page'])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg text-sm">@lang('boilerplate::auth.register.intro')</p>
        {!! Form::open(['route' => 'boilerplate.register', 'method' => 'post', 'autocomplete'=> 'off']) !!}
            @component('boilerplate::input', ['name' => 'first_name', 'placeholder' => 'boilerplate::auth.fields.first_name', 'append-text' => 'fas fa-fw fa-user', 'autofocus' => true])@endcomponent
            @component('boilerplate::input', ['name' => 'last_name', 'placeholder' => 'boilerplate::auth.fields.last_name', 'append-text' => 'far fa-fw fa-user'])@endcomponent
            @component('boilerplate::input', ['name' => 'email', 'placeholder' => 'boilerplate::auth.fields.email', 'append-text' => 'fas fa-fw fa-envelope', 'type' => 'email'])@endcomponent
            @component('boilerplate::password', ['name' => 'password', 'placeholder' => 'boilerplate::auth.fields.password'])@endcomponent
            @component('boilerplate::password', ['name' => 'password_confirmation', 'placeholder' => 'boilerplate::auth.fields.password_confirm', 'check' => false])@endcomponent
            <div class="mb-3">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-primary">
                        @lang('boilerplate::auth.register.register_button')
                    </button>
                </div>
            </div>
        {!! Form::close() !!}
        @if(!$firstUser)
            <p class="mb-0 text-sm">
                <a href="{{ route('boilerplate.login') }}">@lang('boilerplate::auth.register.login_link')</a><br>
            </p>
        @endif
    @endcomponent
@endsection
