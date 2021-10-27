@once
@push('plugin-css')
    <link rel="stylesheet" href="{!! mix('/plugins/fullcalendar/main.min.css', '/assets/vendor/boilerplate') !!}">
@endpush
@push('plugin-js')
    <script src="{!! mix('/plugins/fullcalendar/fullcalendar.min.js', '/assets/vendor/boilerplate') !!}"></script>
@if(App::getLocale() !== 'en')
    <script src="{!! mix('/plugins/fullcalendar/locales/'.App::getLocale().'.js', '/assets/vendor/boilerplate') !!}"></script>
    <script>registerAsset('fullCalendar',()=>{$.fn.fullCalendar.options = {locale:"{{ App::getLocale() }}"}})</script>
@else
    <script>registerAsset('fullCalendar')</script>
@endif
@endpush
@endonce