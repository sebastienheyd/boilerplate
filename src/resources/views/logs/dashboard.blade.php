@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::logs.menu.category'),
    'subtitle' => __('boilerplate::logs.menu.stats'),
    'breadcrumb' => [
        __('boilerplate::logs.menu.stats')
    ]
])

@include('boilerplate::logs.style')

@section('content')
    <div class="row">
        <div class="col-12">
            @component('boilerplate::card')
                @empty($percents)
                    {{ __('boilerplate::logs.list.empty-logs') }}
                @else
                <div class="row">
                    <div class="mb-3 ml-auto mr-auto col-md-6 col-lg-3">
                        <canvas id="stats-doughnut-chart" height="300"></canvas>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            @foreach($percents as $level => $item)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="info-box level level-{{ $level }} {{ $item['count'] === 0 ? 'level-empty' : '' }}">
                                        <span class="info-box-icon">
                                            {!! log_styler()->icon($level) !!}
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ $item['name'] }}</span>
                                            <span class="info-box-number">
                                                {{ __('boilerplate::logs.stats.entries', $item) }}
                                            </span>
                                            <div class="progress">
                                                <div class="progress-bar"
                                                     style="width: {{ $item['percent'] }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endempty
                @slot('footer')
                    <div class="text-right text-muted small">
                        {!! __('boilerplate::logs.vendor') !!}
                    </div>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>
    <script>
        $(function() {
            new Chart($('canvas#stats-doughnut-chart'), {
                type: 'doughnut',
                data:{!! $chartData !!},
                options: {
                    legend: {
                        position: 'bottom'
                    }
                }
            });
        });
    </script>
@endpush