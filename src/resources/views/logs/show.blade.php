@php($date = \Carbon\Carbon::createFromFormat('Y-m-d', $log->date)->isoFormat(__('boilerplate::date.lFdY')))

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
                    <a href="{{ route('boilerplate.logs.download', [$log->date]) }}" class="btn btn-default" data-toggle="tooltip" title="{{ __('boilerplate::logs.show.download') }}">
                        <span class="fa fa-download text-muted"></span>
                    </a>
                    <a href="#delete-log-modal" class="btn btn-danger" data-log-date="{{ $log->date }}" data-toggle="tooltip" title="{{ __('boilerplate::logs.show.delete') }}">
                        <span class="fa fa-trash"></span>
                    </a>
                </span>
            </span>
        </div>
        <div class="col-12 col-xl-3">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6 col-xl-12">
                    @component('boilerplate::card', ['title' => __('boilerplate::logs.show.levels'), 'color' => 'info'])
                        @include('boilerplate::logs._partials.levels')
                    @endcomponent
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-12">
                    @component('boilerplate::card', ['title' => __('boilerplate::logs.show.loginfo'), 'color' => 'warning'])
                        @include('boilerplate::logs._partials.informations')
                    @endcomponent
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-9">
            @component('boilerplate::card', ['title' => ucfirst(__('boilerplate::logs.show.file', ['date' => $date]))])
                <div class="table-responsive">
                    <table id="entries" class="table table-sm">
                        <thead>
                            <tr class="text-center">
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
                                <td class="px-2">
                                    <span class="badge badge-pill bg-purple">
                                        {{ $entry->env }}
                                    </span>
                                </td>
                                <td class="px-2">
                                    <span class="badge badge-pill level-{{ $entry->level }}">
                                        {!! $entry->level() !!}
                                    </span>
                                </td>
                                <td class="px-2">
                                    <span class="badge badge-pill bg-secondary">
                                        {{ $entry->datetime->format('H:i:s') }}
                                    </span>
                                </td>
                                <td class="text-sm">
                                    {{ $entry->header }}
                                </td>
                                <td class="text-right px-2">
                                    @if ($entry->hasStack())
                                        <a class="btn btn-xs btn-default" role="button" data-toggle="collapse" href="#log-stack-{{ $key }}" aria-expanded="false" aria-controls="log-stack-{{ $key }}">
                                            Stack
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @if ($entry->hasStack())
                                <tr class="log-stack {{ $key %2 ? 'even' : 'odd' }}">
                                    <td colspan="5" class="stack">
                                        <div class="stack-content collapse" id="log-stack-{{ $key }}">
                                            {!! preg_replace('`#([0-9]*)\s`', "<br><strong>#$1</strong> ", $entry->stack()) !!}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($entries->hasPages())
                    <div class="panel-footer d-flex justify-content-between align-items-center text-sm">
                        <span class="pull-right small text-muted mtm">
                            {{ __('boilerplate::logs.show.page', ['current' => $entries->currentPage(), 'last' => $entries->lastPage()]) }}
                        </span>
                        {!! $entries->render() !!}
                    </div>
                @endif

            @slot('footer')
                <div class="text-muted text-right small">
                    {!! __('boilerplate::logs.vendor') !!}
                </div>
            @endslot
        @endcomponent
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
                        url: '{{ route('boilerplate.logs.delete') }}',
                        type: 'delete',
                        dataType: 'json',
                        data: {date:el.data('log-date')},
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        cache: false,
                        success: function(res) {
                            location.replace("{{ route('boilerplate.logs.list') }}");
                        }
                    });
                });
            });
        });
    </script>
@endpush
