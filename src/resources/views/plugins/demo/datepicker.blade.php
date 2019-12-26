@include('boilerplate::load.datepicker')

@push('js')
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

        // Date picker
        $('.datepicker').datetimepicker({
            format: 'L'
        });
    });
</script>
@endpush

@component('boilerplate::card', ['color' => 'indigo', 'title' => 'Date picker'])
    @slot('tools')
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
    @endslot
        Usage
        <pre>
&commat;include('boilerplate::load.datepicker')
&commat;push('js')
    &lt;script>
        $('.datepicker').datetimepicker({ format: "L" });
        $('.datetimepicker').datetimepicker();
        $('.daterangepicker').daterangepicker();
    &lt;/script>
&commat;endpush</pre>

        <!-- Date -->
        <div class="form-group">
            <label>Date</label>
            <div class="input-group date">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                </div>
                <input type="text" class="form-control datepicker" id="datepicker" data-toggle="datetimepicker" data-target="#datepicker">
            </div>
        </div>

        <!-- Datetime -->
        <div class="form-group">
            <label>Datetime</label>
            <div class="input-group date">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                </div>
                <input type="text" class="form-control pull-right" id="datetimepicker" data-toggle="datetimepicker" data-target="#datetimepicker">
            </div>
        </div>

        <!-- Date range -->
        <div class="form-group">
            <label>Date range</label>
            <div class="input-group">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                </div>
                <input type="text" class="form-control pull-right" id="reservation">
            </div>
        </div>

        <!-- Date and time range -->
        <div class="form-group">
            <label>Date and time range</label>
            <div class="input-group">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                </div>
                <input type="text" class="form-control pull-right" id="reservationtime">
            </div>
        </div>

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


    @slot('footer')
        <div class="small text-muted text-right">
            <a href="https://tempusdominus.github.io/bootstrap-4/" target="_blank">Tempus Dominus</a> /
            <a href="https://www.daterangepicker.com" target="_blank">Date Range Picker</a>
        </div>
    @endslot
@endcomponent
