@extends('boilerplate::auth.layout', ['title' => __('boilerplate::auth.register.title')])

@section('content')
    @component('boilerplate::auth.loginbox')
        @lang('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.')
        <div class="text-center mt-4">
        <form method="POST" action="{{ route('boilerplate.verification.send') }}">
            @csrf
            <div>
                <button type="submit" class="btn btn-primary mb-3">@lang('Resend Verification Email')</button>
            </div>
        </form>

        <form method="POST" action="{{ route('boilerplate.logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-sm">
                {{ __('Log Out') }}
            </button>
        </form>
        </div>
    @endcomponent
@endsection
