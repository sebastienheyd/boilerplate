@include('boilerplate::load.daterangepicker')
@push('js')
@component('boilerplate::minify')
<script>
    $(function() {
        // Date range picker
        $('#reservation').daterangepicker();
        // Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 15, timePicker24Hour: true, format: 'MM/DD/YYYY hh:mm A'});
        // Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    "Today": [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 days': [moment().subtract(29, 'days'), moment()],
                    'This month': [moment().startOf('month'), moment().endOf('month')],
                    'Last month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );
    });
</script>
@endcomponent
@endpush

@component('boilerplate::card', ['color' => 'red', 'title' => 'Daterangepicker'])
        Usage
        <pre>
&commat;include('boilerplate::load.datepicker')
&commat;push('js')
    &lt;script>
        $('.daterangepicker').daterangepicker();
    &lt;/script>
&commat;endpush</pre>

        <div class="row">
            <div class="col-4">
                <!-- Date range -->
                <div class="form-group">
                    <label>Date range</label>
                    <div class="input-group">
                        <input type="text" class="form-control pull-right" id="reservation">
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <!-- Date and time range -->
                <div class="form-group">
                    <label>Date and time range</label>
                    <div class="input-group">
                        <input type="text" class="form-control pull-right" id="reservationtime">
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <!-- Date and time range -->
                <div class="form-group">
                    <label>Date range button</label>
                    <div class="input-group">
                        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                    <span>
                      <i class="far fa-calendar-alt mr-2"></i>Date range picker
                    </span>
                            <i class="fa fa-caret-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @slot('footer')
        <div class="text-right small text-muted">
            <a href="https://www.daterangepicker.com" target="_blank">Date Range Picker</a>
        </div>
    @endslot
@endcomponent
