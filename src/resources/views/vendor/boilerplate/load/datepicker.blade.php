@if(!defined('LOAD_DATEPICKER'))
    @push('css')
        <link rel="stylesheet" href="{!! mix('/js/datepicker/bootstrap-datepicker3.min.css', '/assets/vendor/boilerplate') !!}">
    @endpush
    @push('js')
        @include('boilerplate::load.moment')
        <script src="{!! mix('/js/datepicker/bootstrap-datepicker.min.js', '/assets/vendor/boilerplate') !!}"></script>
        @if(config('boilerplate.app.locale') !== 'en')
            <script src="{!! asset('/assets/vendor/boilerplate/js/datepicker/locales/bootstrap-datepicker.'.config('boilerplate.app.locale').'.min.js') !!}"></script>
        @endif
        <script>
            $.fn.datepicker.defaults.language = '{{ config('boilerplate.app.locale') }}';
            $.fn.datepicker.defaults.autoclose = true;
        </script>
    @endpush
    @php define('LOAD_DATEPICKER', true) @endphp
@endif