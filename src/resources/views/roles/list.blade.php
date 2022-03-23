@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::role.title'),
    'subtitle' => __('boilerplate::role.list.title'),
    'breadcrumb' => [__('boilerplate::role.title')]
])

@section('content')
    <div class="row">
        <div class="col-sm-12 mb-3">
            <span class="float-right">
                <a href="{{ route("boilerplate.roles.create") }}" class="btn btn-primary">{{ __('boilerplate::role.create.title') }}</a>
            </span>
        </div>
    </div>
    @component('boilerplate::card')
        @component('boilerplate::datatable', ['name' => 'roles']) @endcomponent
    @endcomponent
@endsection
