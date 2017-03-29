@extends('layout.index', [
    'title' => 'Tableau de bord',
    'subtitle' => 'Exemples',
    'breadcrumb' => ['Tableau de bord']]
)

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('_mockup.demo.select2')
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        @include('_mockup.demo.datepicker')
        @include('_mockup.demo.icheck')
        @include('_mockup.demo.datatables')
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        @include('_mockup.demo.bootbox')
        @include('_mockup.demo.notify')
    </div>
</div>
@endsection