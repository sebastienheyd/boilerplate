@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::logs.menu.category'),
    'subtitle' => __('boilerplate::logs.menu.reports'),
    'breadcrumb' => [
        __('boilerplate::logs.menu.reports')
    ]
])

@include('boilerplate::logs.style')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-boilerplate::card>
                <x-boilerplate::datatable name="logs" />
            </x-boilerplate::card>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function () {
            $(document).on('click', '[data-action="delete-log"]', function(e){

                e.preventDefault();
                var el = $(this);
                let inst = window[$(this).closest('.dataTables_wrapper').find('table').data('inst')];

                bootbox.confirm("{{ __('boilerplate::logs.list.deletequestion') }}", function(e){
                    if(e === false) return;

                    $.ajax({
                        url: el.attr('href'),
                        type: 'delete',
                        data: {date:el.data('date')},
                        cache: false,
                        success: function(res) {
                            if (res.success) {
                                inst.ajax.reload(null, false);
                            } else {
                                growl('Error deleting log file', 'error');
                            }
                        }
                    });
                });
            });
        });
    </script>
@endpush