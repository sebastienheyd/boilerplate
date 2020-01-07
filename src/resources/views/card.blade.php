<div class="card {{ isset($tabs) ?  ($outline ?? config('boilerplate.theme.card.outline', false)) ? 'card-outline-tabs' : 'card-tabs' : ''}} {{ ($outline ?? config('boilerplate.theme.card.outline', false)) ? 'card-outline' : '' }} card-{{ $color ?? config('boilerplate.theme.card.default_color', 'info') }}">
    @if($title ?? $header ?? false)
        <div class="card-header {{ isset($tabs) ? ($outline ?? config('boilerplate.theme.card.outline', false)) ? 'p-0' : 'p-0 pt-1' : '' }} border-bottom-0">
            @isset($header)
                {{ $header }}
            @else
                <h3 class="card-title">{{ $title }}</h3>
                @isset($tools)
                    <div class="card-tools">
                        {{ $tools }}
                    </div>
                @endisset
            @endisset
        </div>
    @endif
    <div class="card-body {{ $title ?? false ? ($outline ?? config('boilerplate.theme.card.outline', false)) ? 'pt-0' : '' : '' }}">
        {{ $slot }}
    </div>
    @isset($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
