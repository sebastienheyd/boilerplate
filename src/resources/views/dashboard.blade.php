@extends('boilerplate::layout.index', ['title' => __('boilerplate::layout.dashboard')])

@section('content-header-right')
    @if(config('boilerplate.dashboard.edition', false))
        <section class="mb-2">
            <button type="button" class="btn btn-{{ empty($widgets) ? 'danger' : 'outline-secondary' }} btn-xs" id="toggle-dashboard" data-status="{{ empty($widgets) ? 'unlocked' : 'locked' }}">
                <i class="fa-solid fa-{{ empty($widgets) ? 'lock-open' : 'lock' }} fa-fw"></i> {{ __('boilerplate::dashboard.edit') }}
            </button>
        </section>
    @endif
@endsection

@section('content')
<section id="dashboard-widgets" class="row align-items-start">
@foreach($widgets as $widget)
    {!! $widget !!}
@endforeach
</section>
@endsection

@push('js')
    <script src="{{ mix('dashboard.min.js', '/assets/vendor/boilerplate') }}" data-params="{{ $JSparams }}"></script>
@endpush