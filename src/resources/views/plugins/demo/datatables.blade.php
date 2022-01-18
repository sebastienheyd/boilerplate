@include('boilerplate::load.datatables')

@push('js')
@component('boilerplate::minify')
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
@endcomponent
@endpush

@component('boilerplate::card', ['color' => 'orange', 'title' => 'Datatables'])
    Usage :
    <pre class="mb-3">&lt;x-boilerplate::datatable name="users" /></pre>
    <table class="table table-sm table-striped table-hover" id="dt">
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

    @slot('footer')
        <div class="small text-muted text-right">
            <a href="https://sebastienheyd.github.io/boilerplate/components/datatable" target="_blank">component</a> /
            <a href="https://sebastienheyd.github.io/boilerplate/plugins/datatables" target="_blank">plugin</a> /
            <a href="https://datatables.net/manual/index">datatables</a>
        </div>
    @endslot
@endcomponent
