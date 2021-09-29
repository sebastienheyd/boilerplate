<nav class="main-header navbar navbar-expand{{ config('boilerplate.theme.navbar.bg') === 'white' ? '' : ' navbar-'.config('boilerplate.theme.navbar.bg') }} navbar-{{ setting('darkmode', false) && config('boilerplate.theme.darkmode') ? 'dark' : config('boilerplate.theme.navbar.type') }} {{ config('boilerplate.theme.navbar.border') ? "" : "border-bottom-0" }}" data-type="{{ config('boilerplate.theme.navbar.type') }}">
    <div class="navbar-left d-flex">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link sidebar-toggle px-2" data-widget="pushmenu" href="#">
                    <i class="fas fa-fw fa-bars"></i>
                </a>
            </li>
        </ul>
        @foreach(app('boilerplate.navbar.items')->getItems('left') as $view)
        {!! $view !!}
        @endforeach
    </div>
    <div class="navbar-right ml-auto d-flex">
        @foreach(app('boilerplate.navbar.items')->getItems('right') as $view)
        {!! $view !!}
        @endforeach
        <ul class="nav navbar-nav">
            @if(config('boilerplate.locale.switch', false))
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle px-2" data-toggle="dropdown" href="#" aria-expanded="false">
                    {{ Config::get('boilerplate.locale.languages.'.App::getLocale().'.label') }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" style="left: inherit; right: 0px;">
@foreach(collect(config('boilerplate.locale.languages'))->map(function($e){return $e['label'];})->toArray() as $lang => $label)
@if ($lang !== App::getLocale())
                    <a href="{{ route('boilerplate.lang.switch', $lang) }}" class="dropdown-item">{{ $label }}</a>
@endif
@endforeach
                </div>
            </li>
            @endif
            @if(config('boilerplate.theme.navbar.user.visible'))
            <li class="nav-item">
                <a href="{{ route('boilerplate.user.profile') }}" class="nav-link d-flex align-items-center px-2">
                    <img src="{{ Auth::user()->avatar_url }}" class="avatar-img img-circle bg-gray mr-0 mr-md-2 elevation-{{ config('boilerplate.theme.navbar.user.shadow') }}" alt="{{ Auth::user()->name }}" height="32">
                    <span class="d-none d-md-block">{{ Auth::user()->name }}</span>
                </a>
            </li>
            @endif
            @if(config('boilerplate.theme.darkmode', false))
            <li class="nav-item">
                <a class="nav-link px-2" data-widget="darkmode" href="#" role="button">
                    @if(setting('darkmode', false))
                    <i class="fas fa-fw fa-sun"></i>
                    @else
                    <i class="far fa-fw fa-moon"></i>
                    @endif
                </a>
            </li>
            @endif
            @if(config('boilerplate.theme.fullscreen', false))
            <li class="nav-item">
                <a class="nav-link px-2" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-fw fa-expand-arrows-alt"></i>
                </a>
            </li>
            @endif
            <li class="nav-item">
                {!! Form::open(['route' => 'boilerplate.logout', 'method' => 'post', 'id' => 'logout-form']) !!}
                <button type="submit" class="btn nav-link d-flex align-items-center logout px-2" data-question="{{ __('boilerplate::layout.logoutconfirm') }}">
                    <span class="fa fa-fw fa-power-off hidden-xs pr-1"></span>
                </button>
                {!! Form::close() !!}
            </li>
        </ul>
    </div>
</nav>
