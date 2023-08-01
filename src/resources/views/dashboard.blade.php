@extends('boilerplate::layout.index', ['title' => __('boilerplate::layout.dashboard')])

@section('content')
<section>
    <button type="button" class="btn btn-primary" id="add-a-widget">Add a widget</button>
</section>
@endsection

@push('js')
    <script src="{{ mix('dashboard.min.js', '/assets/vendor/boilerplate') }}" data-params="{{ json_encode(['modal_route' => route('boilerplate.dashboard.add-widget')]) }}"></script>
@endpush