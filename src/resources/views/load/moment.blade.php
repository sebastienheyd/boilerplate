@if(!defined('LOAD_MOMENT'))
    <script src="{!! mix('/js/moment/moment-with-locales.min.js', '/assets/vendor/boilerplate') !!}"></script>
    <script>
        moment.locale('{{ config('boilerplate.app.locale') }}');
    </script>
    @php(define('LOAD_MOMENT', true))
@endif