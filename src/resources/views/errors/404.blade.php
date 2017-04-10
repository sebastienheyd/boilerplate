@extends('boilerplate::auth.layout', ['title' => __('boilerplate::errors.404.title')])

@section('content')
    @component('boilerplate::auth.loginbox')
        <div class="text-center">
            <h2 class="mtn">{{ __('boilerplate::errors.404.title') }}</h2>
            <p>{{ __('boilerplate::errors.404.message') }}</p>
            <p>
                <a href="{{ URL::previous() }}" class="btn btn-primary">{{ __('boilerplate::errors.backlink') }}</a>
            </p>
        </div>
    @endcomponent
@endsection