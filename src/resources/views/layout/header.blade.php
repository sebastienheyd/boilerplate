<nav class="main-header navbar navbar-expand navbar-{{ config('boilerplate.theme.navbar.bg') }} navbar-{{ config('boilerplate.theme.navbar.type') }} {{ config('boilerplate.theme.navbar.border') ? "" : "border-bottom-0" }}">
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
            @if(config('boilerplate.theme.navbar.user.visible'))
            <li class="nav-item">
                <a href="{{ route('boilerplate.user.profile') }}" class="nav-link d-flex align-items-center">
                    <img src="{{ Auth::user()->avatar_url }}" class="avatar-img img-circle bg-gray mr-2 elevation-{{ config('boilerplate.theme.navbar.user.shadow') }}" alt="{{ Auth::user()->name }}" height="32">
                    {{ Auth::user()->name }}
                </a>
            </li>
            @endif
            <li class="nav-item">
                {!! Form::open(['route' => 'boilerplate.logout', 'method' => 'post', 'id' => 'logout-form']) !!}
                <button type="submit" class="btn nav-link d-flex align-items-center logout px-2" data-question="{{ __('boilerplate::layout.logoutconfirm') }}" data-toggle="tooltip" title="{{ __('boilerplate::layout.logout') }}">
                    <span class="fa fa-power-off hidden-xs pr-1"></span>
                </button>
                {!! Form::close() !!}
            </li>
        </ul>
    </div>
</nav>
