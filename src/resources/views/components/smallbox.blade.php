<div class="small-box bg-{{ $color ?? 'info' }}{{ !empty($class) ? ' '.$class : '' }}"{!! empty($attributes) ? '' : ' '.$attributes !!}>
    <div class="inner">
        <h3>{{ $nb ?? 0 }}</h3>
        <p>@lang($text ?? '&nbsp;')</p>
    </div>
    <div class="icon"><i class="{{ $icon ?? 'fas fa-cubes' }}"></i></div>
@if(!empty($link))
    <a href="{!! $link !!}" class="small-box-footer">
        @lang($linkText ?? '')&nbsp;<i class="fas fa-arrow-circle-right ml-1"></i>
    </a>
@endif
</div>
