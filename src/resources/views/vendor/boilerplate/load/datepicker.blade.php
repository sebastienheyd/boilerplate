@if(!defined('LOAD_DATEPICKER'))

    @push('css')
        <link rel="stylesheet" href="{!! asset('/js/plugins/datepicker/datepicker3.css') !!}">
        <link rel="stylesheet" href="{!! asset('/js/plugins/daterangepicker/daterangepicker.css') !!}">
    @endpush

    @push('js')
        @include('boilerplate::load.moment')
        <script src="{!! asset('/js/plugins/datepicker/bootstrap-datepicker.js') !!}"></script>
        @if(config('app.locale') !== 'en')
            <script src="{!! asset('/js/plugins/datepicker/locales/bootstrap-datepicker.'.config('app.locale').'.js') !!}"></script>
        @endif
        <script src="{!! asset('/js/plugins/daterangepicker/daterangepicker.js') !!}"></script>
        <script>
            $.fn.datepicker.defaults.language = '{{ config('app.locale') }}';
            $.fn.datepicker.defaults.autoclose = true;
        </script>
    @endpush

    @php define('LOAD_DATEPICKER', true) @endphp
@endif