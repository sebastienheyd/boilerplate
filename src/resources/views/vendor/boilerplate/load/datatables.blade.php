@if(!defined('LOAD_DATATABLES'))

    @push('css')
    <link rel="stylesheet" href="{!! asset('/js/plugins/datatables/dataTables.bootstrap.css') !!}">
    @endpush

    @push('js')
    <script src="{!! asset('/js/plugins/datatables/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('/js/plugins/datatables/dataTables.bootstrap.min.js') !!}"></script>

    @if(!defined('LOAD_MOMENT'))

        <script src="{!! asset('/js/plugins/daterangepicker/moment.min.js') !!}"></script>
        <?php define('LOAD_MOMENT', true)  ?>
    @endif

    <script src="{!! asset('/js/plugins/datatables/plugins/sorting/datetime-moment.js') !!}"></script>
    <script>
        moment.locale('fr');

        $.fn.dataTable.moment( 'DD/MM/YYYY' );
        $.fn.dataTable.moment( 'DD/MM/YYYY hh:mm' );

        $.extend( true, $.fn.dataTable.defaults, {
            language: {
                url: "/js/plugins/datatables/plugins/i18n/French.json"
            }
        });
    </script>
    @endpush

    <?php define('LOAD_DATATABLES', true)  ?>
@endif