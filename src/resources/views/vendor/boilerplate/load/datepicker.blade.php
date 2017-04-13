@if(!defined('LOAD_DATEPICKER'))

    @push('css')
        <link rel="stylesheet" href="{!! asset('/js/plugins/datepicker/datepicker3.css') !!}">
        <link rel="stylesheet" href="{!! asset('/js/plugins/daterangepicker/daterangepicker.css') !!}">
    @endpush

    @push('js')
        @include('boilerplate::load.moment')
        <script src="{!! asset('/js/plugins/datepicker/bootstrap-datepicker.js') !!}"></script>
        @if(App::getLocale() !== 'en')
            <script src="{!! asset('/js/plugins/datepicker/locales/bootstrap-datepicker.'.App::getLocale().'.js') !!}"></script>
        @endif
        <script src="{!! asset('/js/plugins/daterangepicker/daterangepicker.js') !!}"></script>
        <script>
            $.fn.datepicker.defaults.language = '{{ App::getLocale() }}';
            $.fn.datepicker.defaults.autoclose = true;
        </script>
    @endpush

    @php define('LOAD_DATEPICKER', true) @endphp
@endif