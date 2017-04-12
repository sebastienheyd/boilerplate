@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::users.title'),
    'subtitle' => __('boilerplate::users.list.title'),
    'breadcrumb' => [
        __('boilerplate::users.title') => 'users.index'
    ]
])

@section('content')
    <div class="row">
        <div class="col-sm-12 mbl">
            <span class="btn-group pull-right">
                <a href="{{ route("users.create") }}" class="btn btn-primary">
                    {{ __('boilerplate::users.create.title') }}
                </a>
            </span>
        </div>
    </div>
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">{{ __('boilerplate::users.list.title') }}</h3>
        </div>
        <div class="box-body">
            <table class="table table-striped table-hover va-middle" id="users-table">
                <thead>
                <tr>
                    <th>{{ __('boilerplate::users.list.id') }}</th>
                    <th>{{ __('boilerplate::users.list.state') }}</th>
                    <th>{{ __('boilerplate::users.list.lastname') }}</th>
                    <th>{{ __('boilerplate::users.list.firstname') }}</th>
                    <th>{{ __('boilerplate::users.list.email') }}</th>
                    <th>{{ __('boilerplate::users.list.roles') }}</th>
                    <th>{{ __('boilerplate::users.list.creationdate') }}</th>
                    <th>{{ __('boilerplate::users.list.lastconnect') }}</th>
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
                {data: 'actions', name: 'actions', orderable: false, searchable: false, width : '60px'}
            ]
        });

        $('#users-table').on('click', '.destroy', function (e) {
            e.preventDefault();

            var href = $(this).attr('href');

            bootbox.confirm("{{ __('boilerplate::users.list.confirmdelete') }}", function (result) {
                if (result === false) return;

                $.ajax({
                    url: href,
                    method: 'delete',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(){
                        oTable.ajax.reload();
                        growl("{{ __('boilerplate::users.list.deletesuccess') }}", "success");
                    }
                });
            });
        });
    });
</script>
@endpush