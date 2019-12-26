<div class="card {{ ($outline ?? config('boilerplate.theme.card.outline', false)) ? 'card-outline' : '' }} card-{{ $color ?? config('boilerplate.theme.card.default_color', 'info') }}">
    @if($title ?? false)
    <div class="card-header border-bottom-0">
        <h3 class="card-title">{{ $title }}</h3>
        @if($tools ?? false)
            <div class="card-tools">
                {{ $tools }}
            </div>
        @endif
    </div>
    @endif
    <div class="card-body {{ $title ?? false ? 'pt-0' : '' }}">
        {{ $slot }}
    </div>
    @if($footer ?? false)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>