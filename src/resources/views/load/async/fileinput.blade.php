@once
@component('boilerplate::minify')
    <script>
        loadStylesheet('{!! mix('/plugins/fileinput/bootstrap-fileinput.min.css', '/assets/vendor/boilerplate') !!}');
        loadScript('{!! mix('/plugins/fileinput/bootstrap-fileinput.min.js', '/assets/vendor/boilerplate') !!}', () => {
            loadScript('/assets/vendor/boilerplate/plugins/fileinput/themes/fas/theme.min.js', () => {
                $.fn.fileinput.defaults = $.extend({}, $.fn.fileinput.defaults, $.fn.fileinputThemes.fas);
                @if(App::getLocale() !== 'en')
                loadScript('/assets/vendor/boilerplate/plugins/fileinput/locales/{{ App::getLocale() }}.js', () => {
                    $.fn.fileinput.defaults.language='{{ App::getLocale() }}';
                    registerAsset('fileinput');
                });
                @else
                    registerAsset('fileinput');
                @endif
            });
        });
    </script>
@endcomponent
@endonce