@if(!defined('LOAD_DATATABLES'))

    @push('css')
    <link rel="stylesheet" href="{!! asset('/mix/plugins/datatables/dataTables.bootstrap.css') !!}">
    @endpush

    @push('js')
    <script src="{!! asset('/mix/plugins/datatables/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('/mix/plugins/datatables/dataTables.bootstrap.min.js') !!}"></script>

    @if(!defined('LOAD_MOMENT'))
        <script src="{!! asset('/mix/plugins/datatables/plugins/moment.min.js') !!}"></script>
        <?php define('LOAD_MOMENT', true)  ?>
    @endif

    <script src="{!! asset('/mix/plugins/datatables/plugins/datetime-moment.js') !!}"></script>
    <script>
        moment.locale('fr');

        $.fn.dataTable.moment( 'DD/MM/YYYY' );
        $.fn.dataTable.moment( 'DD/MM/YYYY hh:mm' );

        $.extend( true, $.fn.dataTable.defaults, {
            language: {
                url: "/mix/plugins/datatables/langs/French.json"
            }
        });
    </script>
    @endpush

    <?php define('LOAD_DATATABLES', true)  ?>
@endif