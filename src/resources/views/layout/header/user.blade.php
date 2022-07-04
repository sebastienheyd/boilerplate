<li class="nav-item">
    <a href="{{ route('boilerplate.user.profile') }}" class="nav-link d-flex align-items-center px-2">
        <img src="{{ Auth::user()->avatar_url }}" class="avatar-img img-circle bg-gray mr-0 mr-md-2 elevation-{{ config('boilerplate.theme.navbar.user.shadow') }}" alt="{{ Auth::user()->name }}" height="32">
        <span class="d-none d-md-block">
            <span>{{ Auth::user()->first_name }}</span>
            <span class="text-uppercase font-weight-bolder">{{ Auth::user()->last_name }}</span>
        </span>
    </a>
</li>