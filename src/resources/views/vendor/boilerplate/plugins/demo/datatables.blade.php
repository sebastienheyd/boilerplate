@include('boilerplate::load.datatables')

@push('js')
<script>
    $(function() {
        $('#dt').dataTable({
            columns : [
                null,
                null,
                { render: function(data) { return moment(data).format('YYYY-MM-DD hh:mm') } }
            ]
        });
    });
</script>
@endpush

<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">Datatables</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        Usage :
        <pre>
&commat;include('boilerplate::load.datatables')
&commat;push('js')
    &lt;script>
        $('#dt').dataTable();
    &lt;/script>
&commat;endpush</pre>

        <table class="table table-condensed table-hover" id="dt">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Orlo Bashirian</td>
                <td>qWaelchi@hotmail.com</td>
                <td>2017-03-01 13:12</td>
            </tr>
            <tr>
                <td>Martina Armstrong</td>
                <td>Hertha92@yahoo.com</td>
                <td>2016-06-08 14:16</td>
            </tr>
            <tr>
                <td>Mandy Legros</td>
                <td>Kirsten68@gmail.com</td>
                <td>2017-08-15 12:10</td>
            </tr>
            <tr>
                <td>Anne Franecki</td>
                <td>Iva.shoen@hayley.com</td>
                <td>2017-08-15 12:15</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>