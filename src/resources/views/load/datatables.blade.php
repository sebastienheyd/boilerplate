@once
@push('plugin-css')
    <link rel="stylesheet" href="{!! mix('/plugins/datatables/datatables.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('js')
@include('boilerplate::load.moment')
    <script src="{!! mix('/plugins/datatables/datatables.min.js', '/assets/vendor/boilerplate') !!}"></script>
    <script>$.extend(true,$.fn.dataTable.defaults,{autoWidth:false,language:{url:"{!! mix('/plugins/datatables/i18n/'.$locale.'.json', '/assets/vendor/boilerplate') !!}"}});</script>
@endpush
@endonce
{{-- Plugins --}}
@foreach($plugins as $plugin)
@if($$plugin ?? false)
@once
@push('css')
    <link rel="stylesheet" href="{!! mix('/plugins/datatables/plugins/'.$plugin.'.bootstrap4.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('js')
    <script src="{!! mix('/plugins/datatables/plugins/dataTables.'.$plugin.'.min.js', '/assets/vendor/boilerplate') !!}"></script>
    <script src="{!! mix('/plugins/datatables/plugins/'.$plugin.'.bootstrap4.min.js', '/assets/vendor/boilerplate') !!}"></script>
@endpush
@endonce
@endif
@endforeach

