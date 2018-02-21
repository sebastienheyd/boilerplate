@if(!defined('LOAD_DATETIMEPICKER'))

    @push('css')
        <link rel="stylesheet" href="{!! asset('/js/plugins/datepicker/datepicker3.css') !!}">
        <link rel="stylesheet" href="{!! asset('/js/plugins/datetimepicker/bootstrap-datetimepicker.css') !!}">
    @endpush

    @push('js')
        @include('boilerplate::load.moment')
        <script src="{!! asset('/js/plugins/datepicker/bootstrap-datepicker.js') !!}"></script>
        @if(App::getLocale() !== 'en')
            <script src="{!! asset('/js/plugins/datepicker/locales/bootstrap-datepicker.'.App::getLocale().'.js') !!}"></script>
        @endif
        <script src="{!! asset('/js/plugins/datetimepicker/bootstrap-datetimepicker.js') !!}"></script>
        <script>
            $.fn.datepicker.defaults.language = '{{ App::getLocale() }}';
            $.fn.datepicker.defaults.autoclose = true;
        </script>
    @endpush

    @php define('LOAD_DATETIMEPICKER', true) @endphp
@endif