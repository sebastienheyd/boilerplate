@once
@push('plugin-css')
    <link rel="stylesheet" href="{!! mix('/plugins/fullcalendar/main.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('js')
    <script src="{!! mix('/plugins/fullcalendar/fullcalendar.min.js', '/assets/vendor/boilerplate') !!}"></script>
@if(App::getLocale() !== 'en')
    <script src="{!! mix('/plugins/fullcalendar/locales/'.App::getLocale().'.js', '/assets/vendor/boilerplate') !!}"></script>
    <script>$.fn.fullCalendar.options = {locale:"{{ App::getLocale() }}"}</script>
@endif
@endpush
@endonce