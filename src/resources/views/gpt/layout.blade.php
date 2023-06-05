<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    @stack('plugin-css')
    <link rel="stylesheet" href="{{ mix('/plugins/fontawesome/fontawesome.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="stylesheet" href="{{ mix('/adminlte.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('/plugins/tinymce/plugins/gpt/gpt.min.css', '/assets/vendor/boilerplate') }}">
    @stack('css')
    <script src="{{ mix('/bootstrap.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/plugins/tinymce/plugins/gpt/generator.min.js', '/assets/vendor/boilerplate') }}"></script>
    @component('boilerplate::minify')
        <script>
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
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
<body class="sidebar-mini{{ setting('darkmode', false) && config('boilerplate.theme.darkmode') ? ' dark-mode accent-light' : '' }}">
    <div id="content" style="display: none">
        <div id="gpt-result"></div>
        <div class="text-center mt-3">
            <button type="button" id="stop" class="btn btn-secondary"><i class="fa-solid fa-stop mr-1"></i> Stop generation</button>
        </div>
        <div id="buttons" style="display: none">
            <button type="button" id="undo" class="btn btn-secondary"><i class="fa-solid fa-pencil mr-1"></i> @lang('boilerplate::gpt.form.modify')</button>
            <span>
                <button type="button" id="copy" class="btn btn-secondary"><i class="fa-regular fa-copy mr-1"></i> @lang('boilerplate::gpt.form.copy')</button>
                <button type="button" id="confirm" class="btn btn-primary"><i class="fa-solid fa-check mr-1"></i> @lang('boilerplate::gpt.form.confirm')</button>
            </span>
        </div>
    </div>
    <div id="form">
        <div class="container-fluid pt-2">
            <div id="gpt-form">
                @include('boilerplate::gpt.tabs')
            </div>
        </div>
    </div>
    @component('boilerplate::minify')
    <script>
        window.gpt = {
            route: '{{ route('boilerplate.gpt.process') }}',
            stream: '{{ route('boilerplate.gpt.stream') }}',
            error: "@lang('boilerplate::gpt.error')",
            copy: "@lang('boilerplate::gpt.copy')",
            copyerror: "@lang('boilerplate::gpt.copyerror')",
        };
    </script>
    @endcomponent
@stack('js')
</body>