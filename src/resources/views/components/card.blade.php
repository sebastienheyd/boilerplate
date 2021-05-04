<div class="card{{ isset($tabs) ? ($outline ? ' card-outline card-outline-tabs' : ' card-tabs') : ($outline ? ' card-outline' : '') }} card-{{ $color ?? config('boilerplate.theme.card.default_color', 'info') }} bg-{{ $bgColor ?? 'white' }}{{ $collapsed ? ' collapsed-card' : '' }}{{ !empty($class) ? ' '.$class : '' }}"{!! empty($attributes) ? '' : ' '.$attributes !!}>
@if($title ?? $header ?? false)
    <div class="card-header{{ isset($tabs) ? ($outline ? ' p-0' : ' p-0 pt-1') : '' }} border-bottom-0">
@isset($header)
        {{ $header }}
@else
        <h3 class="card-title">@lang($title ?? '')</h3>
@if($tools ?? $maximize ?? $reduce ?? $close ?? false)
        <div class="card-tools">
@isset($tools)
            {{ $tools ?? '' }}
@endisset
@if($maximize)
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
@endif
@if($reduce)
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-{{ $collapsed ? 'plus' : 'minus' }}"></i></button>
@endif
@if($close)
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
@endif
        </div>
@endisset
@endisset
    </div>
@endif
    <div class="card-body{{ $title ?? false ? ($outline ? ' pt-0' : '') : '' }}">{{ $slot }}</div>
@isset($footer)
    <div class="card-footer">{{ $footer }}</div>
@endif
</div>
