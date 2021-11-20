@once
@component('boilerplate::minify')
    <script>
        loadScript('{!! mix('/plugins/moment/moment-with-locales.min.js', '/assets/vendor/boilerplate') !!}', () => {
            moment.locale('{{ App::getLocale() }}');
            registerAsset('momentjs');
        });
    </script>
@endcomponent
@endonce