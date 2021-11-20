@component('boilerplate::card', ['color' => 'red', 'title' => 'Daterangepicker'])
        Usage
        <pre>&lt;x-boilerplate::daterangepicker name="range" /></pre>
        <div class="row">
            <div class="col-12">
                <x-boilerplate::daterangepicker name="test" label="test" :min-date="\Illuminate\Support\Carbon::now()->subDays(30)" :maxDate="\Illuminate\Support\Carbon::now()" />
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <!-- Date range -->
                @component('boilerplate::daterangepicker', ['name' => 'range1', 'label' => 'Date range picker', 'appendText' => 'far fa-calendar', 'start' => \Illuminate\Support\Carbon::now()->subDays(10), 'end' => \Illuminate\Support\Carbon::now()])@endcomponent
            </div>
            <div class="col-6">
                <!-- Date and time range -->
                @component('boilerplate::daterangepicker', ['name' => 'range2', 'label' => 'Date and time range picker', 'appendText' => 'far fa-clock', 'start' => \Illuminate\Support\Carbon::now()->subDays(10)->subHour(), 'end' => \Illuminate\Support\Carbon::now(), 'timePicker' => true])@endcomponent
            </div>
        </div>
    @slot('footer')
        <div class="text-right small text-muted">
            <a href="https://www.daterangepicker.com" target="_blank">Date Range Picker</a>
        </div>
    @endslot
@endcomponent
