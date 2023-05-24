@php($darkmode = (setting('darkmode', false) && config('boilerplate.theme.darkmode')))
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
    <script src="{{ mix('/bootstrap.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/admin-lte.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/boilerplate.min.js', '/assets/vendor/boilerplate') }}"></script>
@component('boilerplate::minify')
    <script>
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
        bootbox.setLocale('{{ App::getLocale() }}');
        var bpRoutes={
            settings:"{{ route('boilerplate.user.settings',null,false) }}"
        };
        var session={
            keepalive:"{{ route('boilerplate.keepalive', null, false) }}",
            expire:{{ time() +  config('session.lifetime') * 60 }},
            lifetime:{{ config('session.lifetime') * 60 }},
            id:"{{ session()->getId() }}"
        };
    </script>
@endcomponent
@stack('plugin-js')
</head>
<body class="layout-fixed layout-navbar-fixed sidebar-mini{{ $darkmode ? ' dark-mode' : '' }}{{ setting('sidebar-collapsed', false) ? ' sidebar-collapse' : '' }}" data-darkmode="{{ setting('darkmode', '2') }}">
    <div class="wrapper">
        @include('boilerplate::layout.header')
        @include('boilerplate::layout.mainsidebar')
        <div class="content-wrapper{{ $darkmode ? ' accent-light' : ' accent-dark' }}" id="content-wrapper">
            @include('boilerplate::layout.contentheader')
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        @includeWhen(config('boilerplate.theme.footer.visible', true), 'boilerplate::layout.footer')
        <aside class="control-sidebar control-sidebar-{{ config('boilerplate.theme.sidebar.type') }} elevation-{{ config('boilerplate.theme.sidebar.shadow') }}">
            <button class="btn btn-sm" data-widget="control-sidebar"><span class="fa fa-times"></span></button>
            <div class="control-sidebar-content">
                <div class="p-3">
                    @yield('right-sidebar')
                </div>
            </div>
        </aside>
        <div class="control-sidebar-bg"></div>
    </div>
@stack('js')
@if(session('growl'))
    <script>growl("{!! session('growl')[0] ?? session('growl') !!}", "{{ session('growl')[1] ?? 'info' }}")</script>
@endif
</body>
</html>
