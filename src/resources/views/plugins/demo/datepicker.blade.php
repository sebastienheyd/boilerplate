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
        $('#datepicker').datepicker();

        // Datetime picker
        $('#datetimepicker').datetimepicker();
    });
</script>
@endpush

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Date picker</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        Usage
        <pre>
&commat;include('boilerplate::load.datepicker')
&commat;push('js')
    &lt;script>
        $('.datepicker').datepicker();
        $('.datetimepicker').datetimepicker();
        $('.daterangepicker').daterangepicker();
    &lt;/script>
&commat;endpush</pre>

        <!-- Date -->
        <div class="form-group">
            <label>Date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker">
            </div>
        </div>

        <!-- Datetime -->
        <div class="form-group">
            <label>Datetime</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datetimepicker">
            </div>
        </div>

        <!-- Date range -->
        <div class="form-group">
            <label>Date range</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="reservation">
            </div>
        </div>

        <!-- Date and time range -->
        <div class="form-group">
            <label>Date and time range</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
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
                      <i class="fa fa-calendar"></i> Date range picker
                    </span>
                    <i class="fa fa-caret-down"></i>
                </button>
            </div>
        </div>

    </div>
    <div class="box-footer small text-muted text-right">
        <a href="https://bootstrap-datepicker.readthedocs.io/en/latest/" target="_blank">datepicker</a> /
        <a href="http://eonasdan.github.io/bootstrap-datetimepicker/" target="_blank">datetimepicker</a> /
        <a href="https://www.daterangepicker.com" target="_blank">daterangepicker</a>
    </div>
</div>
