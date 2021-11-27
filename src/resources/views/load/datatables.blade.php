@once
@push('plugin-css')
    <link rel="stylesheet" href="{!! mix('/plugins/datatables/datatables.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('plugin-js')
@include('boilerplate::load.moment')
    <script src="{!! mix('/plugins/datatables/datatables.min.js', '/assets/vendor/boilerplate') !!}"></script>
    <script>$.extend(true,$.fn.dataTable.defaults,{autoWidth:false,language:{url:"{!! mix('/plugins/datatables/i18n/'.$locale.'.json', '/assets/vendor/boilerplate') !!}"}});</script>
@endpush
@foreach($plugins as $plugin)
@if($$plugin ?? false)
@push('plugin-css')
    <link rel="stylesheet" href="{!! mix('/plugins/datatables/plugins/'.$plugin.'.bootstrap4.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('plugin-js')
    <script src="{!! mix('/plugins/datatables/plugins/dataTables.'.$plugin.'.min.js', '/assets/vendor/boilerplate') !!}"></script>
    <script src="{!! mix('/plugins/datatables/plugins/'.$plugin.'.bootstrap4.min.js', '/assets/vendor/boilerplate') !!}"></script>
    @if($plugin === 'buttons')
        <script src="{!! mix('/plugins/datatables/buttons.min.js', '/assets/vendor/boilerplate') !!}"></script>
    @endif
@endpush
@endif
@endforeach
@push('plugin-js')
    <script>registerAsset('datatables')</script>
@endpush
@endonce
