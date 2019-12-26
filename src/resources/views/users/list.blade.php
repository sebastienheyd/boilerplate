@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::users.title'),
    'subtitle' => __('boilerplate::users.list.title'),
    'breadcrumb' => [
        __('boilerplate::users.title') => 'boilerplate.users.index'
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="btn-group float-right pb-3">
                <a href="{{ route("boilerplate.users.create") }}" class="btn btn-primary">
                    {{ __('boilerplate::users.create.title') }}
                </a>
            </span>
        </div>
    </div>
    @component('boilerplate::card')
        <table class="table table-striped table-hover va-middle" id="users-table">
            <thead>
            <tr>
                <th>{{-- id --}}</th>
                <th>{{-- avatar --}}</th>
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
    @endcomponent
@endsection

@include('boilerplate::load.datatables')

@push('js')
    <script>
        $(function () {
            oTable = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                order: [[7, "desc"]],
                ajax: {
                    url: '{!! route('boilerplate.users.datatable') !!}',
                    type: 'post',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'avatar', name: 'avatar', searchable: false, sortable: false},
                    {data: 'status', name: 'status', searchable: false},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'email', name: 'email'},
                    {data: 'roles', name: 'roles', searchable: false},
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false,
                        render: $.fn.dataTable.render.moment('{{ __('boilerplate::date.YmdHis') }}')
                    },
                    {
                        data: 'last_login',
                        name: 'last_login',
                        searchable: false,
                        render: $.fn.dataTable.render.fromNow()
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        width: '80px',
                        class: 'visible-on-hover'
                    }
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
                        success: function () {
                            oTable.ajax.reload();
                            growl("{{ __('boilerplate::users.list.deletesuccess') }}", "success");
                        }
                    });
                });
            });
        });
    </script>
@endpush