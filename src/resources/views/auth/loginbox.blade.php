<div class="login-box">
    <div class="login-logo">
        {!! $title or config('app.title') !!}
    </div>

    <div class="login-box-body">
        {{ $slot }}
    </div>
</div>