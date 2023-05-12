@extends('boilerplate::auth.layout', ['title' => __('boilerplate::auth.login.title')])

@section('content')
    <div class="login-logo">
        {!! config('boilerplate.theme.sidebar.brand.logo.icon') ?? '' !!}
        {!! config('boilerplate.theme.sidebar.brand.logo.text') ?? $title ?? '' !!}
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <div class="alert alert-danger text-center">
                @lang('boilerplate::auth.impersonate.not_authorized', ['user' => Auth::user()->name, 'page' => parse_url(session()->get('referer'))['path']])
            </div>

            <div class="d-flex">
                <a href="{{ route('boilerplate.impersonate.stop', [], false) }}" class="btn btn-primary mr-3" data-toggle="tooltip" title="">
                    <span>@lang('boilerplate::auth.impersonate.back_to_impersonator', ['user' => $impersonator->name])</span>
                </a>

                <a href="{{ route('boilerplate.dashboard', [], false) }}" class="btn btn-primary" data-toggle="tooltip" title="">
                    <span>@lang('boilerplate::auth.impersonate.back_to_dashboard')</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        html, .login-page {
            height: 100% !important;
        }
    </style>
@endpush
