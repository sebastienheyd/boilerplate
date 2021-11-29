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
        <x-boilerplate::datatable name="roles" />
    @endcomponent
@endsection

@push('js')
@component('boilerplate::minify')
    <script>
        $(function () {
            $(document).on('click', '.destroy', function (e) {
                e.preventDefault();

                var href = $(this).attr('href');

                bootbox.confirm("{{ __('boilerplate::role.list.confirmdelete') }}", function (result) {
                    if (result === false) return;

                    $.ajax({
                        url: href,
                        method: 'delete',
                        success: function(){
                            dtRoles.ajax.reload();
                            growl("{{ __('boilerplate::role.list.deletesuccess') }}", 'success');
                        }
                    });
                });
            });
        });
    </script>
@endcomponent
@endpush
