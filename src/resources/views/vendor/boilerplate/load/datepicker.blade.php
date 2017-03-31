@if(!defined('LOAD_DATEPICKER'))

    @push('css')
        <link rel="stylesheet" href="{!! asset('/js/plugins/datepicker/datepicker3.css') !!}">
        <link rel="stylesheet" href="{!! asset('/js/plugins/daterangepicker/daterangepicker.css') !!}">
    @endpush

    @push('js')

        @if(!defined('LOAD_MOMENT'))
            <script src="{!! asset('/js/plugins/daterangepicker/moment.min.js') !!}"></script>
            <?php define('LOAD_MOMENT', true)  ?>
        @endif

        <script src="{!! asset('/js/plugins/datepicker/bootstrap-datepicker.js') !!}"></script>
        <script src="{!! asset('/js/plugins/datepicker/locales/bootstrap-datepicker.fr.js') !!}"></script>

        <script src="{!! asset('/js/plugins/daterangepicker/daterangepicker.js') !!}"></script>

        <script>
            $.fn.datepicker.defaults.language = 'fr';
            $.fn.datepicker.defaults.autoclose = true;
        </script>
    @endpush

    <?php define('LOAD_DATEPICKER', true)  ?>
@endif