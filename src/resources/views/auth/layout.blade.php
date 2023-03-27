<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="@lang('boilerplate::layout.direction')">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ config('boilerplate.theme.favicon') ?? mix('favicon.svg', '/assets/vendor/boilerplate') }}">
@stack('plugin-css')
    <link rel="stylesheet" href="{{ mix('/plugins/fontawesome/fontawesome.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="stylesheet" href="{{ mix('/adminlte.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
    @stack('css')
</head>
<body class="hold-transition login-page">
    @yield('content')
    <script src="{{ mix('/bootstrap.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/admin-lte.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/boilerplate.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script>$.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});</script>
@if(config('boilerplate.theme.darkmode'))
    <script>window.matchMedia("(prefers-color-scheme: dark)") ? $('body').addClass('dark-mode accent-light') : $('body').removeClass('dark-mode accent-light')</script>
@endif
@stack('js')
</body>
</html>
