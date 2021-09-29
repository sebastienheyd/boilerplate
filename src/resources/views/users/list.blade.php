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
            <select name="state" class="form-control select2" data-placeholder="@lang('boilerplate::users.list.state')">
                <option></option>
                <option value="1">@lang('boilerplate::users.active')</option>
                <option value="0">@lang('boilerplate::users.inactive')</option>
            </select>
        </div>
        <div class="form-group">
            <select name="role" class="form-control select2" data-placeholder="@lang('boilerplate::role.role')">
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
                    @lang('boilerplate::users.create.title')
                </a>
            </span>
        </div>
    </div>
    @component('boilerplate::card')
        <div class="table-responsive">
            <table class="table table-striped table-hover va-middle" id="users-list">
                <thead>
                    <tr>
                        <th>{{-- id --}}</th>
                        <th>{{-- avatar --}}</th>
                        <th>@lang('boilerplate::users.list.state')</th>
                        <th>@lang('boilerplate::users.list.lastname')</th>
                        <th>@lang('boilerplate::users.list.firstname')</th>
                        <th>@lang('boilerplate::users.list.email')</th>
                        <th>@lang('boilerplate::users.list.roles')</th>
                        <th>@lang('boilerplate::users.list.creationdate')</th>
                        <th>@lang('boilerplate::users.list.lastconnect')</th>
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
@component('boilerplate::minify')
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
                        render: $.fn.dataTable.render.moment('@lang('boilerplate::date.YmdHis')')
                    },
                    {
                        data: 'last_login',
                        name: 'last_login',
                        searchable: false,
                        render: (date) => {
                            return date === null ? '-' : moment(date).fromNow(date)
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        width: '80px',
                        class: 'visible-on-hover text-nowrap'
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

                bootbox.confirm("@lang('boilerplate::users.list.confirmdelete')", function (result) {
                    if (result === false) return;

                    $.ajax({
                        url: href,
                        method: 'delete',
                        success: function (res) {
                            if(res.success) {
                                oTable.ajax.reload();
                                growl("@lang('boilerplate::users.list.deletesuccess')", "success");
                            } else {
                                growl("@lang('boilerplate::users.list.deleteerror')", "error");
                            }
                        }
                    });
                });
            });
        });
    </script>
@endcomponent
@endpush

@push('css')
    <style>.img-circle { border:1px solid #CCC }</style>
@endpush
