@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::users.title'),
    'subtitle' => __('boilerplate::users.list.title'),
    'breadcrumb' => [
        __('boilerplate::users.title') => 'boilerplate.users.index'
    ]
])

@section('right-sidebar')
    <div id="filters">
        <div class="form-group">
            <select name="state" class="form-control form-control-sm select2" data-placeholder="{{ __('boilerplate::users.list.state') }}">
                <option></option>
                <option value="1">{{ __('boilerplate::users.active') }}</option>
                <option value="0">{{ __('boilerplate::users.inactive') }}</option>
            </select>
        </div>
        <div class="form-group">
            <select name="role" class="form-control input-sm select2" data-placeholder="{{ __('boilerplate::role.role') }}">
                <option></option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->display_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-right pb-3">
                <a href="{{ route("boilerplate.users.create") }}" class="btn btn-primary">
                    {{ __('boilerplate::users.create.title') }}
                </a>
            </span>
        </div>
    </div>
    @component('boilerplate::card')
        <div class="table-responsive">
            <table class="table table-striped table-hover va-middle" id="users-list" style="width:100%">
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
        </div>
    @endcomponent
@endsection

@include('boilerplate::load.datatables')
@include('boilerplate::load.select2')

@push('js')
    <script>
        $('.select2').select2({
            minimumResultsForSearch: -1,
            allowClear: true,
            placeholder: $(this).data('placeholder'),
            width: '100%'
        });

        $(function () {
            var oTable = $('#users-list').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                order: [[7, "desc"]],
                ajax: {
                    url: '{!! route('boilerplate.users.datatable') !!}',
                    type: 'post',
                },
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'avatar', name: 'avatar', searchable: false, sortable: false, width : '32px'},
                    {data: 'status', name: 'users.active', searchable: true},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'email', name: 'email'},
                    {data: 'roles', name: 'roles.name', searchable: false, orderable: false},
                    {
                        data: 'created_at',
                        name: 'users.created_at',
                        searchable: false,
                        render: $.fn.dataTable.render.moment('{{ __('boilerplate::date.YmdHis') }}')
                    },
                    {
                        data: 'last_login',
                        name: 'last_login',
                        searchable: false,
                        render: function(date) {
                            return date === null ? '-' : moment(date).fromNow(date)
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        width: '80px',
                        class: 'visible-on-hover'
                    }
                ],
                fnInitComplete: function() {
                    $('#users-list_filter').append('<button class="btn btn-default btn-sm ml-2" data-widget="control-sidebar" data-slide="true"><span class="fa fa-filter"></span></button>')
                }
            });

            $('#filters select').on('change', function() {
                localStorage.setItem('user_search_'+$(this).attr('name'), $(this).val());
                oTable.column(($(this).attr('name') === 'state' ? 2 : 6)).search($(this).val()).draw()
            })

            if (localStorage.getItem('user_search_state')) {
                value = localStorage.getItem('user_search_state');
                $('#filters select[name=state]').val(value).trigger('change')
                oTable.column(2).search(value).draw();
            }

            if (localStorage.getItem('user_search_role')) {
                value = localStorage.getItem('user_search_role');
                $('#filters select[name=role]').val(value).trigger('change')
                oTable.column(6).search(value).draw();
            }

            $(document).on('click', '#users-list .destroy', function (e) {
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
