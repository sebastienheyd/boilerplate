@include('load.datatables')

@push('js')
<script>
    $(function() {
        $('#dt').dataTable({
            columns : [
                null,
                null,
                { render: function(data) { return moment(data).format('DD/MM/YYYY hh:mm') } }
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
        <p class="small mbl">
            Ajoutez <code>&commat;include('load.datatables')</code> dans la vue et appelez dataTable via <code>&commat;push('js')</code>
        </p>
        <table class="table table-condensed table-hover" id="dt">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>DUPONT</td>
                <td>Jean</td>
                <td>2017-03-01 13:12</td>
            </tr>
            <tr>
                <td>MARTIN</td>
                <td>Henri</td>
                <td>2016-06-08 14:16</td>
            </tr>
            <tr>
                <td>MULLER</td>
                <td>Michel</td>
                <td>2017-08-15 12:10</td>
            </tr>
            <tr>
                <td>KLEIN</td>
                <td>Gérard</td>
                <td>2017-08-15 12:15</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>