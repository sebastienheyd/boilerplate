<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ mix('css/boilerplate.css') }}">
    @stack('css')
</head>
<body class="{{ $bodyClass or 'login-page'}}">
    @yield('content')
    <script src="{{ mix('js/boilerplate.js') }}"></script>
    @stack('js')
</body>
</html>