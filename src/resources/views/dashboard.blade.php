@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::layout.dashboard'),
    'subtitle' => 'Components & plugins demo',
    'breadcrumb' => ['Components & plugins demo']]
)

@section('content')
    @include('boilerplate::plugins.demo')
@endsection