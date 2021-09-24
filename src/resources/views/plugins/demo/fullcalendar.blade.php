@include('boilerplate::load.fullcalendar')

@push('js')
@component('boilerplate::minify')
    <script>
        $('#calendar').fullCalendar({
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            buttonIcons: false,
            navLinks: true,
            editable: true,
            dayMaxEvents: true,
            events: 'https://fullcalendar.io/demo-events.json?overload-day'
        })
    </script>
@endcomponent
@endpush

@component('boilerplate::card', ['color' => 'success', 'title' => 'FullCalendar'])
    Usage :
    <pre>
&commat;include('boilerplate::load.fullcalendar')
&commat;push('js')
    &lt;script>
        var calendar = $('#calendar').fullCalendar({
            buttonIcons: false,
        });
    &lt;/script>
&commat;endpush</pre>

    <div id='calendar'></div>

    @slot('footer')
        <div class="text-muted small text-right">
            <a href="https://fullcalendar.io" target="_blank">FullCalendar</a>
        </div>
    @endslot
@endcomponent
