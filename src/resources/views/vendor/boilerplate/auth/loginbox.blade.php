<div class="login-box">
    <div class="login-logo">
        {!! $title or config('boilerplate.app.logo-lg') !!}
    </div>

    <div class="login-box-body">
        {{ $slot }}
    </div>
</div>