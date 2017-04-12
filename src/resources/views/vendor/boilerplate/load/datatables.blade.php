@if(!defined('LOAD_DATATABLES'))

    @push('css')
    <link rel="stylesheet" href="{!! asset('/js/plugins/datatables/dataTables.bootstrap.css') !!}">
    @endpush

    @push('js')
    <script src="{!! asset('/js/plugins/datatables/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('/js/plugins/datatables/dataTables.bootstrap.min.js') !!}"></script>

    @include('boilerplate::load.moment')

    <script src="{!! asset('/js/plugins/datatables/plugins/sorting/datetime-moment.js') !!}"></script>
    <script>
        $.extend( true, $.fn.dataTable.defaults, {
            language: {
                url: "/js/plugins/datatables/plugins/i18n/{{ $locale }}.json"
            }
        });
    </script>
    @endpush

    @php define('LOAD_DATATABLES', true) @endphp
@endif