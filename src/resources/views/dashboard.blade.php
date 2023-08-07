@extends('boilerplate::layout.index', ['title' => __('boilerplate::layout.dashboard')])

@section('content-header-right')
    @if(config('boilerplate.dashboard.edition', false))
        <section class="mb-2">
            <button type="button" class="btn btn-danger btn-xs" id="toggle-dashboard" data-status="{{ empty($widgets) ? 'unlocked' : 'locked' }}" data-toggle="tooltip" title="Édition du tableau de bord">
                <i class="fa-solid fa-{{ empty($widgets) ? 'lock-open' : 'lock' }} fa-fw"></i>
            </button>
        </section>
    @endif
@endsection

@section('content')
<section id="dashboard-widgets" class="row"></section>
@endsection

@push('js')
    <script src="{{ mix('dashboard.min.js', '/assets/vendor/boilerplate') }}" data-params="{{ $JSparams }}"></script>
@endpush