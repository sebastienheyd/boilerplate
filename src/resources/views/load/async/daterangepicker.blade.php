@once
    <script>
        loadStylesheet("{!! mix('/plugins/datepicker/daterangepicker.min.css', '/assets/vendor/boilerplate') !!}");
        loadScript('{!! mix('/plugins/moment/moment-with-locales.min.js', '/assets/vendor/boilerplate') !!}', () => {
            moment.locale('{{ App::getLocale() }}');
            loadScript("{!! mix('/plugins/datepicker/daterangepicker.min.js', '/assets/vendor/boilerplate') !!}", () => {
                registerAsset('daterangepicker');
                $.fn.daterangepicker.defaultOptions = {
                    locale: {
                        "applyLabel": "@lang('boilerplate::daterangepicker.applyLabel')",
                        "cancelLabel": "@lang('boilerplate::daterangepicker.cancelLabel')",
                        "fromLabel": "@lang('boilerplate::daterangepicker.fromLabel')",
                        "toLabel": "@lang('boilerplate::daterangepicker.toLabel')",
                        "customRangeLabel": "@lang('boilerplate::daterangepicker.customRangeLabel')",
                    }
                };
            });
        });
    </script>
@endonce