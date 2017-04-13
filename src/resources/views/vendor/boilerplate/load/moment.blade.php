@if(!defined('LOAD_MOMENT'))
    <script src="{!! asset('/js/plugins/moment/min/moment-with-locales.min.js') !!}"></script>
    <script>moment.locale('{{ App::getLocale() }}');</script>
    @php define('LOAD_MOMENT', true) @endphp
@endif