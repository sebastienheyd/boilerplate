<div class="form-group{{ !empty($class) ? ' '.$class : '' }}">
    <div class="custom-control custom-switch custom-switch-off-{{ $colorOff ?? 'light' }} custom-switch-on-{{ $colorOn ?? 'primary' }}"{!! !empty($attributes) ? ' '.$attributes : '' !!}>
        <input type="{{ $type ?? 'checkbox' }}" class="custom-control-input" id="{{ $id }}"{{ $checked ? ' checked' : '' }}{!! !empty($name) ? ' name="'.$name.'"' : '' !!}{!! !empty($value) ? ' value="'.$value.'"' : '' !!}>
        <label class="custom-control-label font-weight-normal" for="{{ $id }}">@lang($label ?? '')</label>
    </div>
</div>