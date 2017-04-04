@extends('boilerplate::layout.index', [
    'title' => 'Gestion des rôles',
    'subtitle' => 'Liste des rôles',
    'breadcrumb' => ['Gestion des rôles']
])

@section('content')
    <div class="row">
        <div class="col-sm-12 mbl">
            <span class="pull-right">
                <a href="{{ URL::route("roles.create") }}" class="btn btn-primary">Ajouter un rôle</a>
            </span>
        </div>
    </div>
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Liste des rôles</h3>
        </div>
        <div class="box-body">
            <table class="table table-striped table-hover va-middle" id="roles-table">
                <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td><strong>{{ __($role->display_name) }}</strong></td>
                        <td>{{ $role->name }}</td>
                        <td>{{ __($role->description) }}</td>
                        <td>
                            <a href="{{ URL::route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function () {

        $('#roles-table').on('click', '.destroy', function (e) {
            e.preventDefault();

            var href = $(this).attr('href');
            var line = $(this).closest('tr');

            bootbox.confirm("Confirmez vous la suppression du rôle ?", function (result) {
                if (result === false) return;

                $.ajax({
                    url: href,
                    method: 'delete',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(){
                        line.remove();
                        growl("Le rôle a été correctement supprimé");
                    }
                });
            });
        });
    });
</script>
@endpush