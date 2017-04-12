<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ mix('css/boilerplate.css') }}">
    @stack('css')
</head>
<body class="sidebar-mini skin-blue">
    <div class="wrapper">
        @include('boilerplate::layout.header')
        @include('boilerplate::layout.mainsidebar')
        <div class="content-wrapper">
            <section class="content-header">
                @include('boilerplate::layout.contentheader')
            </section>
            <section class="content">
                @yield('content')
            </section>
        </div>
    </div>
    <script src="{{ mix('/js/boilerplate.js') }}"></script>
    <script>
        $(function() {
            @if(Session::has('growl'))
                @if(is_array(Session::get('growl')))
                    growl("{!! Session::get('growl')[0] !!}", "{{ Session::get('growl')[1] }}");
                @else
                    growl("{{Session::get('growl')}}");
                @endif
            @endif
        });
    </script>
    @stack('js')
</body>
</html>