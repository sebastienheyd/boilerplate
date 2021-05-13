@once
@push('css')
    <link rel="stylesheet" href="{!! mix('/plugins/datatables/datatables.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('js')
@include('boilerplate::load.moment')
    <script src="{!! mix('/plugins/datatables/datatables.min.js', '/assets/vendor/boilerplate') !!}"></script>
    <script>$.extend(true,$.fn.dataTable.defaults,{language:{url:"{!! mix('/plugins/datatables/i18n/'.$locale.'.json', '/assets/vendor/boilerplate') !!}"}});</script>
@endpush
@endonce