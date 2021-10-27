@once
@push('plugin-css')
    <link rel="stylesheet" href="{!! mix('/plugins/datepicker/daterangepicker.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('plugin-js')
    @include('boilerplate::load.moment')
    <script src="{!! mix('/plugins/datepicker/daterangepicker.min.js', '/assets/vendor/boilerplate') !!}"></script>
    @component('boilerplate::minify')
    <script>
        registerAsset('daterangepicker');
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
    @endcomponent
@endpush
@endonce