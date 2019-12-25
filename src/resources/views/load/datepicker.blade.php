@if(!defined('LOAD_DATEPICKER'))
    @push('css')
        <link rel="stylesheet" href="{!! mix('/js/datepicker/datepicker.min.css', '/assets/vendor/boilerplate') !!}">
    @endpush
    @push('js')
        @include('boilerplate::load.moment')
        <script src="{!! mix('/js/datepicker/datepicker.min.js', '/assets/vendor/boilerplate') !!}"></script>
        <script>
            $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
                locale: '{{ config('boilerplate.app.locale') }}',
                icons: $.extend({}, $.fn.datetimepicker.Constructor.Default.icons, {
                    time: 'far fa-clock',
                    date: 'far fa-calendar-alt',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                })
            });
        </script>
    @endpush
    @php(define('LOAD_DATEPICKER', true))
@endif
