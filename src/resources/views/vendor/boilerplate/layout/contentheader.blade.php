<h1>
    {{ $title }}
    @if(isset($subtitle))
        <small>{{ $subtitle }}</small>
    @endif
</h1>
<ol class="breadcrumb">
    <li>
        <a href="{{ route('boilerplate.home') }}">
            <i class="fa fa-home"></i> {{ __('boilerplate::layout.home') }}
        </a>
    </li>
    @if(isset($breadcrumb))
        @foreach($breadcrumb as $label => $route)
            @if(is_numeric($label))
                <li class="active">{{ $route }}</li>
            @elseif(is_array($route))
                <li><a href="{{ route($route[0], $route[1]) }}">{{ $label }}</a></li>
            @else
                <li><a href="{{ route($route) }}">{{ $label }}</a></li>
            @endif
        @endforeach
    @endif
</ol>