@if(!defined('LOAD_FULLCALENDAR'))
    @push('css')
        <link rel="stylesheet" href="{!! mix('/js/fullcalendar/main.min.css', '/assets/vendor/boilerplate') !!}">
    @endpush
    @push('js')
        <script src="{!! mix('/js/fullcalendar/main.min.js', '/assets/vendor/boilerplate') !!}"></script>
        <script src="{!! mix('/js/fullcalendar/jquery.fullcalendar.min.js', '/assets/vendor/boilerplate') !!}"></script>
        @if(App::getLocale() !== 'en')
            <script src="{!! mix('/js/fullcalendar/locales/'.App::getLocale().'.js', '/assets/vendor/boilerplate') !!}"></script>
            <script>$.fn.fullCalendar.options = {locale:"{{ App::getLocale() }}"}</script>
        @endif
    @endpush
    @push('css')
        <style>.fc .fc-toolbar.fc-header-toolbar { padding:0 }</style>
    @endpush
    @php(define('LOAD_FULLCALENDAR', true))
@endif
