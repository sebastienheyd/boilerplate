@extends('boilerplate::layout.index', [
    'title' => 'Tableau de bord',
    'subtitle' => 'Exemples',
    'breadcrumb' => ['Tableau de bord']]
)

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('boilerplate::_mockup.demo.select2')
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        @include('boilerplate::_mockup.demo.datepicker')
        @include('boilerplate::_mockup.demo.icheck')
        @include('boilerplate::_mockup.demo.datatables')
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        @include('boilerplate::_mockup.demo.bootbox')
        @include('boilerplate::_mockup.demo.notify')
    </div>
</div>
@endsection