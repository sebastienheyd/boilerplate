@extends('boilerplate::auth.layout', ['title' => __('boilerplate::auth.password_reset.title')])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg text-sm">@lang('boilerplate::auth.password_reset.intro')</p>
        @component('boilerplate::form', ['route' => 'boilerplate.password.reset.post'])
            @component('boilerplate::input', ['type' => 'hidden', 'name' => 'token', 'value' => $token])@endcomponent
            @component('boilerplate::input', ['name' => 'email', 'placeholder' => 'boilerplate::auth.fields.email', 'append-text' => 'fas fa-fw fa-envelope', 'type' => 'email', 'value' => $email, 'autofocus' => true])@endcomponent
            @component('boilerplate::password', ['name' => 'password', 'placeholder' => 'boilerplate::auth.fields.password'])@endcomponent
            @component('boilerplate::password', ['name' => 'password_confirmation', 'placeholder' => 'boilerplate::auth.fields.password_confirm', 'check' => false])@endcomponent
            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-primary" type="submit">@lang('boilerplate::auth.password_reset.submit')</button>
                </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
