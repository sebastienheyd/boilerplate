@if(!defined('LOAD_DATATABLES'))
    @push('css')
    <link rel="stylesheet" href="{!! mix('/js/datatables/datatables.min.css', '/assets/vendor/boilerplate') !!}">
    @endpush
    @push('js')
    @include('boilerplate::load.moment')
    <script src="{!! mix('/js/datatables/datatables.min.js', '/assets/vendor/boilerplate') !!}"></script>
    <script>
        $.extend( true, $.fn.dataTable.defaults, {
            language: {
                url: "/assets/vendor/boilerplate/js/datatables/i18n/{{ $locale }}.json"
            }
        });
    </script>
    @endpush
    @php(define('LOAD_DATATABLES', true))
@endif