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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ __('boilerplate::logs.list.title') }}</h3>
                </div>
                <div class="box-body">
                    {!! $rows->render() !!}
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-stats">
                            <thead>
                            <tr>
                                @foreach($headers as $key => $header)
                                    <th class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                        @if ($key == 'date')
                                            {{ $header }}
                                        @else
                                            <span class="level level-{{ $key }}">
                                                {!! log_styler()->icon($key) . ' ' . $header !!}
                                            </span>
                                        @endif
                                    </th>
                                @endforeach
                                <th class="text-right">{{ __('boilerplate::logs.list.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($rows->count() > 0)
                                @foreach($rows as $date => $row)
                                    <tr>
                                        @foreach($row as $key => $value)
                                            <td class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                                @if ($key == 'date')
                                                    <a href="{{ route('logs.show', [$date]) }}">
                                                        <span class="label label-primary">
                                                            {{ Date::createFromFormat('Y-m-d', $value)->format(__('boilerplate::date.Ymd')) }}
                                                        </span>
                                                    </a>
                                                @elseif ($value == 0)
                                                    <span class="level level-empty">{{ $value }}</span>
                                                @else
                                                    <a href="{{ route('logs.filter', [$date, $key]) }}">
                                                        <span class="level level-{{ $key }}">{{ $value }}</span>
                                                    </a>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="text-right">
                                            <a href="{{ route('logs.show', [$date]) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a href="#delete-log-modal" class="btn btn-sm btn-danger" data-log-date="{{ $date }}">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11" class="text-center">
                                        <span class="label label-default">{{ trans('log-viewer::general.empty-logs') }}</span>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    {!! $rows->render() !!}
                </div>
                <div class="box-footer">
                    <span class="pull-right text-muted small">
                        {!! __('boilerplate::logs.vendor') !!}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function () {
            $('a[href="#delete-log-modal"]').on('click', function(e){

                e.preventDefault();
                var el = $(this);

                bootbox.confirm("{{ __('boilerplate::logs.list.deletequestion') }}", function(e){
                    if(e === false) return;

                    $.ajax({
                        url: '{{ route('logs.delete') }}',
                        type: 'delete',
                        dataType: 'json',
                        data: {date:el.data('log-date')},
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
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