<div class="form-group{{ !empty($class) ? ' '.$class : '' }}">
    <div class="icheck-{{ $color ?? 'primary' }}"{!! !empty($attributes) ? ' '.$attributes : '' !!}>
        <input type="{{ $type ?? 'checkbox' }}" id="{{ $id }}"{{ $checked ? ' checked' : '' }}{{ $disabled ? ' disabled' : '' }}{!! !empty($name) ? ' name="'.$name.'"' : '' !!}{!! !empty($value) ? ' value="'.$value.'"' : '' !!}>
        <label for="{{ $id }}" class="font-weight-normal">@lang($label ?? '')</label>
    </div>
</div>
