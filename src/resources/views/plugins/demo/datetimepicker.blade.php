@component('boilerplate::card', ['color' => 'indigo', 'title' => 'Datetimepicker'])
    Usage
    <pre>&lt;x-boilerplate::datetimepicker name="date" /></pre>
    <div class="row">
        <div class="col-6">
            <!-- Date -->
            @component('boilerplate::components.datetimepicker', ['label' => 'Date', 'name' => 'date', 'appendText' => 'far fa-calendar-alt', 'value' => now()])@endcomponent()
        </div>
        <div class="col-6">
            <!-- Datetime -->
            @component('boilerplate::components.datetimepicker', ['label' => 'Datetime', 'name' => 'datetime', 'appendText' => 'far fa-calendar-alt', 'format' => 'L HH:mm:ss', 'show-today' => 'true', 'show-close' => 'true', 'value' => now()])@endcomponent()
        </div>
    </div>
    @slot('footer')
        <div class="text-right small text-muted">
            <a href="https://sebastienheyd.github.io/boilerplate/components/datetimepicker" target="_blank">component</a> /
            <a href="https://getdatepicker.com/5-4/" target="_blank">Tempus Dominus</a>
        </div>
    @endslot
@endcomponent
