@extends('boilerplate::layout.index', [
    'title' => 'Demo',
    'subtitle' => 'Components & plugins demo',
    'breadcrumb' => ['Components & plugins demo']]
)

@section('content')
<div class="row">
    <div class="col-md-6">
        @include('boilerplate::plugins.demo.select2')
        @include('boilerplate::plugins.demo.datetimepicker')
        @include('boilerplate::plugins.demo.icheck')
        @include('boilerplate::plugins.demo.daterangepicker')
        @include('boilerplate::plugins.demo.colorpicker')
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