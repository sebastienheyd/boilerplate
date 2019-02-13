@if(!defined('LOAD_SELECT2'))
    @push('js')
        <script src="{!! mix('/js/select2/select2.full.min.js', '/assets/vendor/boilerplate') !!}"></script>
        <script src="{!! asset('/assets/vendor/boilerplate/js/select2/i18n/'.config('boilerplate.app.locale').'.js') !!}"></script>
    @endpush
    @php(define('LOAD_SELECT2', true))
@endif