<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ mix('/adminlte.min.css', '/assets/vendor/boilerplate') }}">
    @stack('css')
</head>
<body class="layout-fixed layout-navbar-fixed sidebar-mini">
    <div class="wrapper">
        @include('boilerplate::layout.header')
        @include('boilerplate::layout.mainsidebar')
        <div class="content-wrapper">
            @include('boilerplate::layout.contentheader')
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        @includeWhen(config('boilerplate.theme.footer.visible', true), 'boilerplate::layout.footer')
    </div>
    <script src="{{ mix('/bootstrap.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/admin-lte.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/boilerplate.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script>
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});
        bootbox.setLocale('{{ App::getLocale() }}');
        var session = {
            keepalive: "{{ route('boilerplate.keepalive', null, false) }}",
            expire: {{ time() +  config('session.lifetime') * 60 }},
            lifetime:  {{ config('session.lifetime') * 60 }},
            id: "{{ session()->getId() }}"
        }
    </script>
    @if(Session::has('growl'))
        <script>
            $(function() {
                @if(is_array(Session::get('growl')))
                    growl("{!! Session::get('growl')[0] !!}", "{{ Session::get('growl')[1] }}");
                @else
                    growl("{{Session::get('growl')}}");
                @endif
            });
        </script>
    @endif
    @stack('js')
</body>
</html>
