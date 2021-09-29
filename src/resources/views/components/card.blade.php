<div class="card{{ $tabs ? ($outline ? ' card-outline card-outline-tabs' : ' card-tabs') : ($outline ? ' card-outline' : '') }} card-{{ $color ?? config('boilerplate.theme.card.default_color', 'info') }}{{ ($bgColor ?? null) ? ' bg-'.$bgColor : '' }}{{ $collapsed ? ' collapsed-card' : '' }}{{ !empty($class) ? ' '.$class : '' }}"{!! empty($attributes) ? '' : ' '.$attributes !!}>
@if($title ?? false || $header ?? false || $tools ?? false || $maximize || $reduce || $close)
    <div class="card-header{{ $tabs ? ($outline ? ' p-0' : ' p-0 pt-1') : '' }} border-bottom-0">
@if($header ?? false)
        {!! $header !!}
@else
        <h3 class="card-title">@lang($title ?? '')</h3>
@if($tools ?? false || $maximize || $reduce || $close)
        <div class="card-tools">
@isset($tools)
            {!! $tools ?? '' !!}
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
@endif
    </div>
@endif
    <div class="card-body{{ $title ?? false ? ($outline ? ' pt-0' : '') : '' }}">{{ $slot }}</div>
@isset($footer)
    <div class="card-footer">{!! $footer !!}</div>
@endisset
</div>
