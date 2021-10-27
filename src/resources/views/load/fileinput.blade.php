@once
@push('plugin-css')
    <link rel="stylesheet" href="{!! mix('/plugins/fileinput/bootstrap-fileinput.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('plugin-js')
    <script src="{!! mix('/plugins/fileinput/bootstrap-fileinput.min.js', '/assets/vendor/boilerplate') !!}"></script>
    <script src="/assets/vendor/boilerplate/plugins/fileinput/themes/fas/theme.min.js"></script>
    <script>$.fn.fileinput.defaults = $.extend({}, $.fn.fileinput.defaults, $.fn.fileinputThemes.fas);</script>
@if(App::getLocale() !== 'en')
    <script src="/assets/vendor/boilerplate/plugins/fileinput/locales/{{ App::getLocale() }}.js"></script>
    <script>$.fn.fileinput.defaults.language='{{ App::getLocale() }}';</script>
@endif
    <script>registerAsset('fileinput');</script>
@endpush
@endonce