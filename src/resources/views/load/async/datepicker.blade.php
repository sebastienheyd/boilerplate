@once
@component('boilerplate::minify')
<script>
    loadStylesheet('{!! mix('/plugins/datepicker/datetimepicker.min.css', '/assets/vendor/boilerplate') !!}');
    loadScript('{!! mix('/plugins/moment/moment-with-locales.min.js', '/assets/vendor/boilerplate') !!}', () => {
        moment.locale('{{ App::getLocale() }}');
        loadScript('{!! mix('/plugins/datepicker/datetimepicker.min.js', '/assets/vendor/boilerplate') !!}', () => {
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
        });
    });
</script>
@endcomponent
@endonce