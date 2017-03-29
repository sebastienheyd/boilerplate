<h1>
    {{ $title }}
    @if(isset($subtitle))
        <small>{{ $subtitle }}</small>
    @endif
</h1>
<ol class="breadcrumb">
    <li><a href="/"><i class="fa fa-home"></i> Accueil</a></li>
    @if(isset($breadcrumb))
        @foreach($breadcrumb as $label => $route)
            @if(is_numeric($label))
                <li class="active">{{ $route }}</li>
            @else
                <li><a href="{{ route($route) }}">{{ $label }}</a></li>
            @endif
        @endforeach
    @endif
</ol>