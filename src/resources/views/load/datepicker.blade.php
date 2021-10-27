@once
@push('plugin-css')
    <link rel="stylesheet" href="{!! mix('/plugins/datepicker/datetimepicker.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('plugin-js')
    @include('boilerplate::load.moment')
    <script src="{!! mix('/plugins/datepicker/datetimepicker.min.js', '/assets/vendor/boilerplate') !!}"></script>
    @component('boilerplate::minify')
    <script>
        if(! loadedAssets.includes('datetimepicker')) {
            window.loadedAssets.push('datetimepicker');
        }

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
    </script>
    @endcomponent
@endpush
@endonce