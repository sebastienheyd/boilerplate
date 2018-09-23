<div class="login-box">
    <div class="login-logo">
        {!! config('boilerplate.app.logo-lg') ?? $title !!}
    </div>

    <div class="login-box-body">
        {{ $slot }}
    </div>
</div>