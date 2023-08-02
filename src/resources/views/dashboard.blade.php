@extends('boilerplate::layout.index', ['title' => __('boilerplate::layout.dashboard')])

@section('content-header-right')
    <section class="mb-2">
        <button type="button" class="btn btn-secondary btn-sm" id="add-a-widget" data-toggle="tooltip" title="Gestion des widgets">
            <i class="fa-solid fa-gear"></i>
        </button>
    </section>
@endsection

@section('content')

<section id="dashboard-widgets"></section>
@endsection

@push('js')
    <script src="{{ mix('dashboard.min.js', '/assets/vendor/boilerplate') }}" data-params="{{ $params }}"></script>
@endpush