@extends('boilerplate::layout.index', [
    'title' => 'Gestion des utilisateurs',
    'subtitle' => "Liste des utilisateurs",
    'breadcrumb' => ['Gestion des utilisateurs' => 'users.index']
])

@section('content')
    <div class="row">
        <div class="col-sm-12 mbl">
            <span class="btn-group pull-right">
                <a href="{{ route("users.create") }}" class="btn btn-primary">
                    Ajouter un utilisateur
                </a>
            </span>
        </div>
    </div>
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Liste des utilisateurs</h3>
        </div>
        <div class="box-body">
            <table class="table table-striped table-hover va-middle" id="users-table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>État</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Role(s)</th>
                    <th>Date de création</th>
                    <th>Dernière connexion</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@include('boilerplate::load.datatables')

@push('js')
<script>
    $(function () {
        oTable = $('#users-table').DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: '{!! route('users.datatable') !!}',
                type: 'post',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'status', name: 'status'},
                {data: 'last_name', name: 'last_name'},
                {data: 'first_name', name: 'first_name'},
                {data: 'email', name: 'email'},
                {data: 'roles', name: 'roles', searchable: false},
                {data: 'created_at', name: 'created_at', searchable: false},
                {data: 'last_login', name: 'last_login', searchable: false},
                {data: 'actions', name: 'actions', orderable: false, searchable: false, width : '80px'}
            ]
        });

        $('#users-table').on('click', '.destroy', function (e) {
            e.preventDefault();

            var href = $(this).attr('href');

            bootbox.confirm("Confirmez vous la suppression de l'utilisateur ?", function (result) {
                if (result === false) return;

                $.ajax({
                    url: href,
                    method: 'delete',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(){
                        oTable.ajax.reload();
                        growl("L'utilisateur à été correctement supprimé");
                    }
                });
            });
        });
    });
</script>
@endpush

@push('styles')
<style>
    .avatar {
        float: left;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #999;
    }
</style>
@endpush