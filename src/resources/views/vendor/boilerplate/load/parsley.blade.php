@if(!defined('LOAD_PARSLEY'))

    @push('css')
        <link rel="stylesheet" href="{!! asset('/js/plugins/parsley/parsley.css') !!}">
    @endpush

    @push('js')
        <script src="{!! asset('/js/plugins/parsley/parsley.min.js') !!}"></script>
        <script src="{!! asset('/js/plugins/parsley/i18n/'.App::getLocale().'.js') !!}"></script>
    @endpush

    @php define('LOAD_PARSLEY', true) @endphp
@endif