@if(!defined('LOAD_FILEINPUT'))
    @push('css')
        <link rel="stylesheet" href="{!! asset('/js/plugins/bootstrap-fileinput/css/fileinput.min.css') !!}">
    @endpush

    @push('js')
        <script src="{!! asset('/js/plugins/bootstrap-fileinput/js/fileinput.min.js') !!}"></script>
        @if(App::getLocale() !== 'en')
            <script src="{!! asset('/js/plugins/bootstrap-fileinput/js/locales/'.App::getLocale().'.js') !!}"></script>
            <script>
                $.fn.fileinput.defaults.language = '{{ App::getLocale() }}';
            </script>
        @endif
    @endpush

    @php define('LOAD_FILEINPUT', true) @endphp
@endif