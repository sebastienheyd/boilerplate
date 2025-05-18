@php($date = $stats['date']->isoFormat(__('boilerplate::date.lFdY')))

@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::logs.menu.category'),
    'subtitle' => __('boilerplate::logs.show.title', ['date' => $date]),
    'breadcrumb' => [
        __('boilerplate::logs.menu.reports') => 'boilerplate.logs.list',
        __('boilerplate::logs.show.title', ['date' => $date])
    ]
])

@include('boilerplate::logs.style')

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('boilerplate.logs.list') }}" class="btn btn-default">
            <span class="far fa-arrow-alt-circle-left text-muted"></span>
        </a>
        <span class="float-right">
            <span class="btn-group">
                <a href="{{ route('boilerplate.logs.download', [$stats['date']->format('Y-m-d')]) }}" class="btn btn-default" data-toggle="tooltip" title="{{ __('boilerplate::logs.show.download') }}">
                    <span class="fa fa-download text-muted"></span>
                </a>
                <a href="#delete-log-modal" class="btn btn-danger" data-date="{{ $stats['date']->format('Y-m-d') }}" data-toggle="tooltip" title="{{ __('boilerplate::logs.show.delete') }}">
                    <span class="fa fa-trash"></span>
                </a>
            </span>
        </span>
    </div>
    <div class="col-12 col-xl-3">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6 col-xl-12">
                <x-boilerplate::card title="boilerplate::logs.show.loginfo" color="warning">
                    <table class="table table-striped no-border table-sm">
                        <tr>
                            <th class="text-nowrap">{{ __('boilerplate::logs.show.filepath') }}</th>
                            <td class="text-word-wrap">{{ $stats['file'] }}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">{{ __('boilerplate::logs.show.logentries') }}</th>
                            <td>{{ $stats['entries'] }}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">{{ __('boilerplate::logs.show.size') }}</th>
                            <td>{{ $stats['sizeFormatted'] }}</td>
                        </tr>
                    </table>
                </x-boilerplate::card>
                <x-boilerplate::card title="boilerplate::logs.show.levels" color="info">
                    <table class="table table-sm table-striped no-border">
                        <tbody>
                        @foreach($stats['levels'] as $level => $count)
                            @if($count === 0)
                                @continue
                            @endif
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span class="badge level-{{ strtolower($level) }}">
                                            {{ ucfirst(strtolower($level)) }}
                                        </span>
                                        <span class="badge badge-pill level-{{ $level }}">
                                            {{ $count }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </x-boilerplate::card>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-9">
        <x-boilerplate::card>
            <x-boilerplate::datatable name="log" :ajax="['log' => $stats['date']->format('Y-m-d')]" />
        </x-boilerplate::card>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).on('click', '.show-stack', function() {
            bootbox.dialog({
                title: 'Stacktrace',
                message: $(this).next('.stacktrace').html(),
                onEscape: true,
                backdrop: true,
                size: 'xl',
            });
        })

        $(function () {
            $('a[href="#delete-log-modal"]').on('click', function(e){

                e.preventDefault();
                var el = $(this);

                bootbox.confirm("{{ __('boilerplate::logs.list.deletequestion') }}", function(e){
                    if(e === false) return;

                    $.ajax({
                        url: '{{ route('boilerplate.logs.delete') }}',
                        type: 'delete',
                        data: {date:el.data('date')},
                        cache: false,
                        success: function(res) {
                            if (res.success) {
                                location.replace("{{ route('boilerplate.logs.list') }}");
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
