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
            @component('boilerplate::card')
                {!! $rows->render() !!}
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm">
                        <thead>
                            <tr>
                                @foreach($headers as $key => $header)
                                    <th class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                        @if ($key == 'date')

                                        @else
                                            <span class="badge badge-pill level-{{ $key }}">
                                                {!! log_styler()->icon($key) . ' ' . $header !!}
                                            </span>
                                        @endif
                                    </th>
                                @endforeach
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if ($rows->count() > 0)
                            @foreach($rows as $date => $row)
                                <tr>
                                    @foreach($row as $key => $value)
                                        <td class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                            @if ($key == 'date')
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $value)->isoFormat(__('boilerplate::date.Ymd')) }}
                                            @elseif ($value == 0)
                                                <span class="text-muted">.</span>
                                            @else
                                                <a href="{{ route('boilerplate.logs.filter', [$date, $key]) }}">
                                                    <span class="text-{{ $key }} text-bold">{{ $value }}</span>
                                                </a>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="text-right visible-on-hover no-wrap">
                                        <a href="{{ route('boilerplate.logs.show', [$date]) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-search"></i>
                                        </a>
                                        <a href="#delete-log-modal" class="btn btn-sm btn-danger" data-log-date="{{ $date }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11" class="text-center">
                                    <span class="badge badge-pill badge-default">{{ __('boilerplate::logs.list.empty-logs') }}</span>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                {!! $rows->render() !!}

            @slot('footer')
                <div class="text-right small text-muted">
                    {!! __('boilerplate::logs.vendor') !!}
                </div>
            @endslot
        @endcomponent
        </div>
    </div>
@endsection

@push('css')
    <style> table tr th { border-top:0 !important } </style>
@endpush

@push('js')
    <script>
        $(function () {
            $('a[href="#delete-log-modal"]').on('click', function(e){

                e.preventDefault();
                var el = $(this);

                bootbox.confirm("{{ __('boilerplate::logs.list.deletequestion') }}", function(e){
                    if(e === false) return;

                    $.ajax({
                        url: '{{ route('boilerplate.logs.delete') }}',
                        type: 'delete',
                        dataType: 'json',
                        data: {date:el.data('log-date')},
                        cache: false,
                        success: function(res) {
                            location.reload();
                        }
                    });
                });
            });
        });
    </script>
@endpush
