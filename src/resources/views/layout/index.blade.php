<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ mix('mix/css/boilerplate.css') }}">
    @stack('css')
</head>
<body class="sidebar-mini skin-blue">
    <div class="wrapper">
        @include('layout.header')
        @include('layout.mainsidebar')
        <div class="content-wrapper">
            <section class="content-header">
                @include('layout.contentheader')
            </section>
            <section class="content">
                @yield('content')
            </section>
        </div>
    </div>
    <script src="{{ mix('mix/js/boilerplate.js') }}"></script>
    <script>
        $(function() {
            @if(Session::has('growl') && Session::has('growl-type'))
                growl("{!!Session::get('growl')!!}", "{{Session::get('growl-type')}}");
            @elseif(Session::has('growl'))
                growl("{{Session::get('growl')}}");
            @endif
        });
    </script>
    @stack('js')
</body>
</html>