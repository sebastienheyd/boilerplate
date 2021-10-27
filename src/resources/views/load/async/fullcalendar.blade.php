@once
@component('boilerplate::minify')
    <script>
        loadStylesheet("{!! mix('/plugins/fullcalendar/main.min.css', '/assets/vendor/boilerplate') !!}");
        loadScript("{!! mix('/plugins/fullcalendar/fullcalendar.min.js', '/assets/vendor/boilerplate') !!}", () => {
            @if(App::getLocale() !== 'en')
                loadScript("{!! mix('/plugins/fullcalendar/locales/'.App::getLocale().'.js', '/assets/vendor/boilerplate') !!}", () => {
                    registerAsset('fullCalendar', () => {
                        $.fn.fullCalendar.options = {locale:"{{ App::getLocale() }}"}
                    });
                })
            @else
                registerAsset('fullCalendar');
            @endif
        });
    </script>
@endcomponent
@endonce