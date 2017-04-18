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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="col-md-3">
                        <canvas id="stats-doughnut-chart" height="300"></canvas>
                    </div>
                    <div class="col-md-9">
                        <section class="box-body">
                            <div class="row">
                                @foreach($percents as $level => $item)
                                    <div class="col-md-4">
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
                        </section>
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