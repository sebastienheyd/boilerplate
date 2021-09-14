<div class="content-header pt-2 pb-1">
    <div class="container-fluid">
        <div class="row mb-2 align-items-end">
            <div class="col-sm-6">
                <h1 class="m-0">
                    {{ $title }}
                    @if(isset($subtitle))
                        <small class="font-weight-light ml-1 text-md">{{ $subtitle }}</small>
                    @endif
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-sm">
                    <li class="breadcrumb-item">
                        <a href="{{ route('boilerplate.dashboard') }}">
                            {{ __('boilerplate::layout.home') }}
                        </a>
                    </li>
                    @if(isset($breadcrumb))
                        @foreach($breadcrumb as $label => $route)
                            @if(is_numeric($label))
                                <li class="breadcrumb-item active">{{ $route }}</li>
                            @elseif(is_array($route))
                                <li class="breadcrumb-item"><a href="{{ route($route[0], $route[1]) }}">{{ $label }}</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ route($route) }}">{{ $label }}</a></li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>
