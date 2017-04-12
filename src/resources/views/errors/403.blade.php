@extends('boilerplate::auth.layout', ['title' => __('boilerplate::errors.403.title')])

@section('content')
    @component('boilerplate::auth.loginbox')
        <div class="text-center">
            <h2 class="mtn">{{ __('boilerplate::errors.403.title') }}</h2>
            <p>{{ __('boilerplate::errors.403.message') }}</p>
            <p>
                <a href="{{ URL::previous() }}" class="btn btn-primary">{{ __('boilerplate::errors.backlink') }}</a>
                @if(Auth::check())
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default">
                        {{ __('boilerplate::layout.logout') }}
                    </a>
                    {!! Form::open(['route' => 'logout', 'method' => 'post', 'id' => 'logout-form', 'style'=> 'display:none']) !!}
                    {!! Form::close() !!}
                @endif
            </p>
        </div>
    @endcomponent
@endsection