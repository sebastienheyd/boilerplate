<header class="main-header">
    <a href="{{ route('boilerplate.home') }}" class="logo">
        <span class="logo-mini">{!! config('boilerplate.app.logo-mini') !!}</span>
        <span class="logo-lg">{!! config('boilerplate.app.logo-lg') !!}</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ route('user.profile') }}">
                        <img src="{{ Auth::user()->avatar_url }}" class="user-image avatar" alt="User Image"/>
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="logout">
                        <span class="hidden-xs">
                            <span class="fa fa-power-off"></span> {{ __('boilerplate::layout.logout') }}
                        </span>
                    </a>
                    {!! Form::open(['route' => 'logout', 'method' => 'post', 'id' => 'logout-form', 'style'=> 'display:none']) !!}
                    {!! Form::close() !!}
                </li>
            </ul>
        </div>
    </nav>
</header>