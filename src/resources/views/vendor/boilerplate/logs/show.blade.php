@php
    $date = Date::createFromFormat('Y-m-d', $log->date)->format(__('boilerplate::date.lFdY'));
@endphp

@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::logs.menu.category'),
    'subtitle' => __('boilerplate::logs.show.title', ['date' => $date]),
    'breadcrumb' => [
        __('boilerplate::logs.menu.reports') => 'logs.list',
        __('boilerplate::logs.show.title', ['date' => $date])
    ]
])

@include('boilerplate::logs.style')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mbm">
            <a href="{{ route('logs.list') }}" class="btn btn-default">
                {{ __('boilerplate::logs.show.backtolist') }}
            </a>
            <span class="pull-right btn-group">
                <a href="{{ route('logs.download', [$log->date]) }}" class="btn btn-default">
                    {{ __('boilerplate::logs.show.download') }}
                </a>
                <a href="#delete-log-modal" class="btn btn-danger" data-log-date="{{ $log->date }}">
                    {{ __('boilerplate::logs.show.delete') }}
                </a>
            </span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ ucfirst(__('boilerplate::logs.show.file', ['date' => $date])) }}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2">
                            @include('boilerplate::logs._partials.menu')
                        </div>
                        <div class="col-md-10">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    {{ __('boilerplate::logs.show.loginfo') }}
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                        <tr>
                                            <td>{{ __('boilerplate::logs.show.filepath') }}</td>
                                            <td colspan="5">{{ $log->getPath() }}</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{ __('boilerplate::logs.show.logentries') }}</td>
                                            <td>
                                                <span class="label label-primary">{{ $entries->total() }}</span>
                                            </td>
                                            <td>{{ __('boilerplate::logs.show.size') }}</td>
                                            <td>
                                                <span class="label label-primary">{{ $log->size() }}</span>
                                            </td>
                                            <td>{{ __('boilerplate::logs.show.createdat') }}</td>
                                            <td>
                                                <span class="label label-primary">
                                                    {{ Date::createFromFormat('Y-m-d H:i:s', $log->createdAt())->format(__('boilerplate::date.YmdHis')) }}
                                                </span>
                                            </td>
                                            <td>{{ __('boilerplate::logs.show.updatedat') }}</td>
                                            <td>
                                                <span class="label label-primary">
                                                    {{ Date::createFromFormat('Y-m-d H:i:s', $log->updatedAt())->format(__('boilerplate::date.YmdHis')) }}
                                                </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                @if ($entries->hasPages())
                                    <div class="panel-heading">
                                        <span class="pull-right small text-muted mtm">
                                            {{ __('boilerplate::logs.show.page', ['current' => $entries->currentPage(), 'last' => $entries->lastPage()]) }}
                                        </span>
                                        {!! $entries->render() !!}
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table id="entries" class="table table-hover table-condensed">
                                        <thead>
                                        <tr>
                                            <th>{{ __('boilerplate::logs.show.env') }}</th>
                                            <th style="width: 120px;">{{ __('boilerplate::logs.show.level') }}</th>
                                            <th style="width: 65px;">{{ __('boilerplate::logs.show.time') }}</th>
                                            <th>{{ __('boilerplate::logs.show.header') }}</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($entries as $key => $entry)
                                            <tr class="{{ $key %2 ? 'even' : 'odd' }}">
                                                <td>
                                                    <span class="label label-env">
                                                        {{ $entry->env }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="level level-{{ $entry->level }}">
                                                        {!! $entry->level() !!}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="label label-default">
                                                        {{ $entry->datetime->format('H:i:s') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <p>{{ $entry->header }}</p>
                                                </td>
                                                <td class="text-right">
                                                    @if ($entry->hasStack())
                                                        <a class="btn btn-xs btn-default" role="button" data-toggle="collapse" href="#log-stack-{{ $key }}" aria-expanded="false" aria-controls="log-stack-{{ $key }}">
                                                            Stack
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($entry->hasStack())
                                                <tr>
                                                    <td colspan="5" class="stack">
                                                        <div class="stack-content collapse" id="log-stack-{{ $key }}">
                                                            {!! $entry->stack() !!}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if ($entries->hasPages())
                                    <div class="panel-footer">
                                        <span class="pull-right small text-muted mtm">
                                            {{ __('boilerplate::logs.show.page', ['current' => $entries->currentPage(), 'last' => $entries->lastPage()]) }}
                                        </span>
                                        {!! $entries->render() !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
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

@push('css')
<style>.pagination { margin: 0; }</style>
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
                        url: '{{ route('logs.delete') }}',
                        type: 'delete',
                        dataType: 'json',
                        data: {date:el.data('log-date')},
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        cache: false,
                        success: function(res) {
                            location.replace("{{ route('logs.list') }}");
                        }
                    });
                });
            });
        });
    </script>
@endpush