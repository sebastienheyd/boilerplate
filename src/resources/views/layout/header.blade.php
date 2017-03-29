<header class="main-header">

    <a href="index2.html" class="logo">
        <span class="logo-mini">{!! config('app.shorttitle') !!}</span>
        <span class="logo-lg">{!! config('app.title') !!}</span>
    </a>

    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="hidden-xs"><span class="fa fa-power-off"></span> Déconnexion</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>