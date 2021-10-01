@extends('boilerplate::auth.layout', ['title' => __('boilerplate::auth.password_reset.title')])

@section('content')
    @component('boilerplate::auth.loginbox')
        <p class="login-box-msg text-sm">@lang('boilerplate::auth.password_reset.intro')</p>
        {!! Form::open(['route' => 'boilerplate.password.reset.post', 'method' => 'post', 'autocomplete'=> 'off']) !!}
            {!! Form::hidden('token', $token) !!}
            @component('boilerplate::input', ['name' => 'email', 'placeholder' => 'boilerplate::auth.fields.email', 'append-text' => 'fas fa-fw fa-envelope', 'type' => 'email', 'value' => $email, 'autofocus' => true])@endcomponent
            @component('boilerplate::password', ['name' => 'password', 'placeholder' => 'boilerplate::auth.fields.password'])@endcomponent
            @component('boilerplate::password', ['name' => 'password_confirmation', 'placeholder' => 'boilerplate::auth.fields.password_confirm', 'check' => false])@endcomponent
            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-primary" type="submit">@lang('boilerplate::auth.password_reset.submit')</button>
                </div>
            </div>
        {!! Form::close() !!}
    @endcomponent
@endsection
