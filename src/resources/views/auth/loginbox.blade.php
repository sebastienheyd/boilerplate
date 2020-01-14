<div class="login-box">
    <div class="login-logo">
        {!! config('boilerplate.theme.sidebar.brand.logo.icon') ?? '' !!}
        {!! config('boilerplate.theme.sidebar.brand.logo.text') ?? $title ?? '' !!}
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            {{ $slot }}
        </div>
    </div>
</div>
