@once
@push('css')
    <link rel="stylesheet" href="{!! mix('/plugins/datepicker/datepicker.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('js')
    @include('boilerplate::load.moment')
    <script src="{!! mix('/plugins/datepicker/datepicker.min.js', '/assets/vendor/boilerplate') !!}"></script>
    <script>
        $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
            locale: "{{ config('boilerplate.app.locale') }}",
            icons: $.extend({}, $.fn.datetimepicker.Constructor.Default.icons, {
                time: "far fa-clock",
                date: "far fa-calendar-alt",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down"
            })
        });
        $.fn.daterangepicker.defaultOptions = {
            locale: {
                "applyLabel": "@lang('boilerplate::daterangepicker.applyLabel')",
                "cancelLabel": "@lang('boilerplate::daterangepicker.cancelLabel')",
                "fromLabel": "@lang('boilerplate::daterangepicker.fromLabel')",
                "toLabel": "@lang('boilerplate::daterangepicker.toLabel')",
                "customRangeLabel": "@lang('boilerplate::daterangepicker.customRangeLabel')",
            }
        };
    </script>
@endpush
@endonce