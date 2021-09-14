<aside class="main-sidebar sidebar-{{ config('boilerplate.theme.sidebar.type') }}-{{ config('boilerplate.theme.sidebar.links.bg') }} elevation-{{ config('boilerplate.theme.sidebar.shadow') }}">
    <a href="{{ route('boilerplate.dashboard') }}" class="brand-link {{ !empty(config('boilerplate.theme.sidebar.brand.bg')) ? 'bg-'.config('boilerplate.theme.sidebar.brand.bg') : ''}}">
        <span class="brand-logo bg-{{ config('boilerplate.theme.sidebar.brand.logo.bg') }} elevation-{{ config('boilerplate.theme.sidebar.brand.logo.shadow') }}">
            {!! config('boilerplate.theme.sidebar.brand.logo.icon') !!}
        </span>
        <span class="brand-text">{!! config('boilerplate.theme.sidebar.brand.logo.text') !!}</span>
    </a>
    <div class="sidebar">
        @if(config('boilerplate.theme.sidebar.user.visible'))
            <div class="user-panel py-3 d-flex">
                <div class="image">
                    <img src="{{ Auth::user()->avatar_url }}" class="avatar-img img-circle elevation-{{ config('boilerplate.theme.sidebar.user.shadow') }}" alt="{{ Auth::user()->name }}">
                </div>
                <div class="info">
                    <a href="{{ route('boilerplate.user.profile') }}" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>
        @endif
        <nav class="mt-3">
            {!! $menu !!}
        </nav>
    </div>
</aside>
