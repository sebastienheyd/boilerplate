<div class="info-box bg-{{ $bgColor ?? 'white' }}{{ !empty($class) ? ' '.$class : '' }}"{!! empty($attributes) ? '' : ' '.$attributes !!}>
    <span class="info-box-icon bg-{{ $color ?? config('boilerplate.theme.card.default_color', 'info') }}">
        <i class="{{ $icon ?? 'fas fa-cubes' }}"></i>
    </span>
    <div class="info-box-content">
        <span class="info-box-text">@lang($text ?? '')</span>
        <span class="info-box-number">{{ $number ?? '' }}</span>
@if(!empty($progress))
        <div class="progress"><div class="progress-bar" style="width:{{ $progress ?? 0 }}%"></div></div>
@endif
@if(!empty($description))
        <span class="progress-description">@lang($description ?? '')</span>
@endif
    </div>
</div>
