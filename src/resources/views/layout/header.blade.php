<nav class="main-header navbar navbar-expand{{ config('boilerplate.theme.navbar.bg') === 'white' ? '' : ' navbar-'.config('boilerplate.theme.navbar.bg') }} navbar-{{ setting('darkmode', false) && config('boilerplate.theme.darkmode') ? 'dark' : config('boilerplate.theme.navbar.type') }} {{ config('boilerplate.theme.navbar.border') ? "" : "border-bottom-0" }}" data-type="{{ config('boilerplate.theme.navbar.type') }}">
    <div class="navbar-left d-flex">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link sidebar-toggle px-2" data-widget="pushmenu" href="#">
                    <i class="fas fa-fw fa-bars"></i>
                </a>
            </li>
            @foreach(app('boilerplate.navbar.items')->getItems('left') as $view){!! $view !!}@endforeach
        </ul>
    </div>
    <div class="navbar-right ml-auto d-flex">
        <ul class="nav navbar-nav">
            @includeWhen(config('boilerplate.theme.navbar.user.visible'), 'boilerplate::layout.header.user')
            @includeWhen((config('boilerplate.app.allowImpersonate') && Auth::user()->hasRole('admin')) || session()->has('impersonate'), 'boilerplate::layout.header.impersonate')
            @foreach(app('boilerplate.navbar.items')->getItems('right') as $view){!! $view !!}@endforeach
            @includeWhen(config('boilerplate.locale.switch', false), 'boilerplate::layout.header.language')
            @includeWhen(config('boilerplate.theme.darkmode', false), 'boilerplate::layout.header.darkmode')
            @includeWhen(config('boilerplate.theme.fullscreen', false), 'boilerplate::layout.header.fullscreen')
            <li class="nav-item">
                @component('boilerplate::form', ['route' => 'boilerplate.logout', 'id' => 'logout-form'])
                <button type="submit" class="btn nav-link d-flex align-items-center logout px-2" data-question="{{ __('boilerplate::layout.logoutconfirm') }}" data-toggle="tooltip" title="@lang('boilerplate::layout.logout')">
                    <span class="fa fa-fw fa-power-off hidden-xs pr-1"></span>
                </button>
                @endcomponent
            </li>
        </ul>
    </div>
</nav>
