@once
@component('boilerplate::minify')
    @include('boilerplate::load.async.moment')
    <script>
        loadStylesheet('{!! mix('/plugins/datepicker/datetimepicker.min.css', '/assets/vendor/boilerplate') !!}');
        whenAssetIsLoaded('momentjs', () => {
            loadScript('{!! mix('/plugins/datepicker/datetimepicker.min.js', '/assets/vendor/boilerplate') !!}', () => {
                registerAsset('datetimepicker', () => {
                    $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
                        locale: "{{ App::getLocale() }}",
                        icons: $.extend({}, $.fn.datetimepicker.Constructor.Default.icons, {
                            time: 'far fa-clock',
                            date: 'far fa-calendar',
                            up: 'fas fa-arrow-up',
                            down: 'fas fa-arrow-down',
                            previous: 'fas fa-chevron-left',
                            next: 'fas fa-chevron-right',
                            today: 'far fa-calendar-check',
                            clear: 'fas fa-trash',
                            close: 'fas fa-times'
                        })
                    });
                })
            });
        });
    </script>
@endcomponent
@endonce