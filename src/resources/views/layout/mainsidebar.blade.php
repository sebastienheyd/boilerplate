<aside class="main-sidebar sidebar-{{ config('boilerplate.theme.sidebar.type') }}-{{ config('boilerplate.theme.sidebar.links.bg') }} elevation-{{ config('boilerplate.theme.sidebar.shadow') }}">
    <a href="{{ route('boilerplate.dashboard') }}" class="brand-link d-flex {{ !empty(config('boilerplate.theme.sidebar.brand.bg')) ? 'bg-'.config('boilerplate.theme.sidebar.brand.bg') : ''}}">
        <span class="brand-logo bg-{{ config('boilerplate.theme.sidebar.brand.logo.bg') }} elevation-{{ config('boilerplate.theme.sidebar.brand.logo.shadow') }}">
            {!! config('boilerplate.theme.sidebar.brand.logo.icon') !!}
        </span>
        <span class="brand-text text-truncate pr-2" title="{!! strip_tags(config('boilerplate.theme.sidebar.brand.logo.text')) !!}">{!! config('boilerplate.theme.sidebar.brand.logo.text') !!}</span>
    </a>
    <div class="sidebar">
        @if(config('boilerplate.theme.sidebar.user.visible'))
            <div class="user-panel d-flex align-items-center">
                <div class="image">
                    <img src="{{ Auth::user()->avatar_url }}" class="avatar-img img-circle elevation-{{ config('boilerplate.theme.sidebar.user.shadow') }}" alt="{{ Auth::user()->name }}">
                </div>
                <div class="info">
                    <a href="{{ route('boilerplate.user.profile') }}" class="d-flex flex-wrap">
                        <span class="mr-1">{{ Auth::user()->first_name }}</span>
                        <span class="text-truncate text-uppercase font-weight-bolder">{{ Auth::user()->last_name }}</span>
                    </a>
                </div>
            </div>
        @endif
        <nav class="mt-2">
            {!! $menu !!}
        </nav>
    </div>
</aside>
