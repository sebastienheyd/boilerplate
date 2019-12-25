<div class="login-box">
    <div class="login-logo">
        {!! config('boilerplate.app.logo-lg') ?? $title !!}
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            {{ $slot }}
        </div>
    </div>
</div>