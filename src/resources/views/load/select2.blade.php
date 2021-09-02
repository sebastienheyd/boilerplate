@once
@push('js')
    <script src="{!! mix('/plugins/select2/select2.full.min.js', '/assets/vendor/boilerplate') !!}"></script>
    <script src="{!! mix('/plugins/select2/i18n/'.App::getLocale().'.js', '/assets/vendor/boilerplate') !!}"></script>
    <script>$.extend(true,$.fn.select2.defaults,{language:'{{ App::getLocale() }}',direction:'@lang('boilerplate::layout.direction')'});</script>
@endpush
@endonce