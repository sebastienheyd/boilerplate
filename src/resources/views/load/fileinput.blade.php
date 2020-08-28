@if(!defined('LOAD_FILEINPUT'))
    @push('css')
        <link rel="stylesheet" href="{!! mix('/js/fileinput/bootstrap-fileinput.min.css', '/assets/vendor/boilerplate') !!}">
    @endpush
    @push('js')
        <script src="{!! mix('/js/fileinput/bootstrap-fileinput.min.js', '/assets/vendor/boilerplate') !!}"></script>
        <script src="{!! asset('/assets/vendor/boilerplate/js/fileinput/themes/fas/theme.min.js') !!}"></script>
        <script>
            $.fn.fileinput.defaults = $.extend({}, $.fn.fileinput.defaults, $.fn.fileinputThemes.fas);
        </script>
        @if(App::getLocale() !== 'en')
            <script src="{!! asset('/assets/vendor/boilerplate/js/fileinput/locales/'.config('boilerplate.app.locale').'.js') !!}"></script>
            <script>
                $.fn.fileinput.defaults.language = '{{ config('boilerplate.app.locale') }}';
            </script>
        @endif
    @endpush
    @php(define('LOAD_FILEINPUT', true))
@endif
