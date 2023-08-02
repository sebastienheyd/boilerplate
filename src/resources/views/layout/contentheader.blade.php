<div class="content-header pt-2 pb-1">
    <div class="container-fluid">
        <div class="d-flex align-items-end flex-wrap justify-content-between pb-2">
            <h1 class="m-0 pr-3">
                {{ $title }}
                @if(isset($subtitle))
                    <small class="font-weight-light ml-1 text-md">{{ $subtitle }}</small>
                @endif
            </h1>
            <div>
                @if(isset($breadcrumb))
                <ol class="breadcrumb text-sm">
                    <li class="breadcrumb-item">
                        <a href="{{ route('boilerplate.dashboard') }}">
                            {{ __('boilerplate::layout.home') }}
                        </a>
                    </li>
                    @foreach($breadcrumb as $label => $route)
                        @if(is_numeric($label))
                            <li class="breadcrumb-item active">{{ $route }}</li>
                        @elseif(is_array($route))
                            <li class="breadcrumb-item"><a href="{{ route($route[0], $route[1]) }}">{{ $label }}</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route($route) }}">{{ $label }}</a></li>
                        @endif
                    @endforeach
                </ol>
                @endif
                @yield('content-header-right')
            </div>
        </div>
    </div>
</div>
