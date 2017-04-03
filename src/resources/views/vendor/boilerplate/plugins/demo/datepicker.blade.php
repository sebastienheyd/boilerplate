@include('boilerplate::load.datepicker')

@push('js')
<script>
    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
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

    //Date picker
    $('#datepicker').datepicker();
</script>
@endpush

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Date picker</h3>
    </div>
    <div class="box-body">
        Usage :
        <pre>
&commat;include('boilerplate::load.datepicker')
&commat;push('js')
    &lt;script>
        $('.daterangepicker').daterangepicker();
        $('.datepicker').datepicker();
    &lt;/script>
&commat;endpush</pre>

        <!-- Date -->
        <div class="form-group">
            <label>Date:</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker">
            </div>
            <!-- /.input group -->
        </div>
        <!-- /.form group -->

        <!-- Date range -->
        <div class="form-group">
            <label>Date range:</label>

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="reservation">
            </div>
            <!-- /.input group -->
        </div>
        <!-- /.form group -->

        <!-- Date and time range -->
        <div class="form-group">
            <label>Date and time range:</label>

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                </div>
                <input type="text" class="form-control pull-right" id="reservationtime">
            </div>
            <!-- /.input group -->
        </div>
        <!-- /.form group -->

        <!-- Date and time range -->
        <div class="form-group">
            <label>Date range button:</label>

            <div class="input-group">
                <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Date range picker
                    </span>
                    <i class="fa fa-caret-down"></i>
                </button>
            </div>
        </div>
        <!-- /.form group -->

    </div>
    <!-- /.box-body -->
</div>