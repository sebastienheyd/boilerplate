@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::role.title'),
    'subtitle' => __('boilerplate::role.list.title'),
    'breadcrumb' => [__('boilerplate::role.title')]
])

@section('content')
    <div class="row">
        <div class="col-sm-12 mb-3">
            <span class="float-right">
                <a href="{{ route("boilerplate.roles.create") }}" class="btn btn-primary">{{ __('boilerplate::role.create.title') }}</a>
            </span>
        </div>
    </div>
    @component('boilerplate::card')
        <div class="table-responsive">
            <table class="table table-striped table-hover va-middle" id="roles-table" style="width:100%">
                <thead>
                <tr>
                    <th>{{ __('boilerplate::role.label') }}</th>
                    <th>{{ __('boilerplate::role.description') }}</th>
                    <th>{{ __('boilerplate::role.permissions') }}</th>
                    <th>{{ __('boilerplate::role.list.nbusers') }}</th>
                    <th>{{-- buttons --}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>
                            <strong data-toggle="tooltip" data-title="{{ $role->name }}">{{ $role->display_name }}</strong>
                        </td>
                        <td>
                            {{ $role->description }}<br />
                        </td>
                        <td>
                            {!! $role->permissions->implode('display_name', ', ') !!}
                        </td>
                        <td>
                            {{ $role->getNbUsers() }}
                        </td>
                        <td class="visible-on-hover" style="width:80px">
                            <a href="{{ route('boilerplate.roles.edit', $role->id) }}" class="btn btn-sm btn-primary">
                                <span class="fa fa-fw fa-pencil-alt"></span>
                            </a>
                            @if($role->name !== 'admin' &&
                                !(config('boilerplate.auth.register') && $role->name === config('boilerplate.auth.register_role')) &&
                                $role->getNbUsers() === 0)
                                <a href="{{ route('boilerplate.roles.destroy', $role->id) }}" class="btn btn-sm btn-danger destroy">
                                    <span class="fa fa-fw fa-trash"></span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endcomponent
@endsection

@include('boilerplate::load.datatables')

@push('js')
<script>
    $(function () {

        $('#roles-table').dataTable({
            ordering: false
        });

        $('#roles-table').on('click', '.destroy', function (e) {
            e.preventDefault();

            var href = $(this).attr('href');
            var line = $(this).closest('tr');

            bootbox.confirm("{{ __('boilerplate::role.list.confirmdelete') }}", function (result) {
                if (result === false) return;

                $.ajax({
                    url: href,
                    method: 'delete',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(){
                        line.remove();
                        growl("{{ __('boilerplate::role.list.deletesuccess') }}", 'success');
                    }
                });
            });
        });
    });
</script>
@endpush
