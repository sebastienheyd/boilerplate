@once
@component('boilerplate::minify')
    <script>
        loadStylesheet('{!! mix('plugins/fileinput/bootstrap-fileinput.min.css', '/assets/vendor/boilerplate') !!}');
        loadScript('{!! mix('plugins/fileinput/bootstrap-fileinput.min.js', '/assets/vendor/boilerplate') !!}', () => {
            loadScript({!! mix('plugins/fileinput/themes/fa6/theme.min.js', '/assets/vendor/boilerplate') !!}, () => {
                $.fn.fileinput.defaults = $.extend({}, $.fn.fileinput.defaults, $.fn.fileinputThemes.fa6);
                @if(App::getLocale() !== 'en')
                loadScript('{!! mix('plugins/fileinput/locales/'.App::getLocale().'.js', '/assets/vendor/boilerplate') !!}', () => {
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
