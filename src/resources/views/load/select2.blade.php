@once
@push('css')
    <link rel="stylesheet" href="{!! mix('/plugins/select2/select2.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('js')
    <script src="{!! mix('/plugins/select2/select2.full.min.js', '/assets/vendor/boilerplate') !!}"></script>
    <script src="{!! mix('/plugins/select2/i18n/'.config('boilerplate.app.locale').'.js', '/assets/vendor/boilerplate') !!}"></script>
    <script>$.extend(true,$.fn.select2.defaults,{language:'{{ config('boilerplate.app.locale') }}',direction:'@lang('boilerplate::layout.direction')'});</script>
@endpush
@endonce