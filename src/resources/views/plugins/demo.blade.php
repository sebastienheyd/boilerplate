@extends('boilerplate::layout.index', [
    'title' => 'Plugins',
    'subtitle' => 'Demo',
    'breadcrumb' => ['Plugins']]
)

@section('content')
<div class="row">
    <div class="col-md-6">
        @include('boilerplate::plugins.demo.select2')
        @include('boilerplate::plugins.demo.datepicker')
        @include('boilerplate::plugins.demo.icheck')
        @include('boilerplate::plugins.demo.codemirror')
        @include('boilerplate::plugins.demo.fileinput')
        @include('boilerplate::plugins.demo.tabs')
    </div>
    <div class="col-md-6">
        @include('boilerplate::plugins.demo.tinymce')
        @include('boilerplate::plugins.demo.datatables')
        @include('boilerplate::plugins.demo.bootbox')
        @include('boilerplate::plugins.demo.notify')
        @include('boilerplate::plugins.demo.fullcalendar')
    </div>
</div>
@endsection
