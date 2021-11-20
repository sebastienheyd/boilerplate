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
            <span class="float-right pb-3">
                <a href="{{ route("boilerplate.users.create") }}" class="btn btn-primary">
                    @lang('boilerplate::users.create.title')
                </a>
            </span>
        </div>
    </div>
    @component('boilerplate::card')
        <x-boilerplate::datatable name="users"/>
    @endcomponent
@endsection

@include('boilerplate::load.datatables')
@include('boilerplate::load.select2')

@push('js')
@component('boilerplate::minify')
    <script>
        $(document).on('click', '#dt_users .destroy', function (e) {
            e.preventDefault();

            var href = $(this).attr('href');

            bootbox.confirm("@lang('boilerplate::users.list.confirmdelete')", function (result) {
                if (result === false) return;

                $.ajax({
                    url: href,
                    method: 'delete',
                    success: function (res) {
                        if(res.success) {
                            dtUsers.ajax.reload(null, false);
                            growl("@lang('boilerplate::users.list.deletesuccess')", "success");
                        } else {
                            growl("@lang('boilerplate::users.list.deleteerror')", "error");
                        }
                    }
                });
            });
        });
    </script>
@endcomponent
@endpush
@push('css')
    <style>.img-circle { border:1px solid #CCC }</style>
@endpush
