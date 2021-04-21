@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::layout.dashboard'),
    'subtitle' => 'Plugins demo',
    'breadcrumb' => ['Plugins demo']]
)

@section('content')
    @include('boilerplate::plugins.demo')
@endsection