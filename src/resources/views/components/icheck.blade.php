<div class="form-group">
    <div class="icheck-{{ $color ?? 'primary' }} d-inline">
        <input type="{{ $type ?? 'checkbox' }}" id="{{ $id }}" {!! $attributes !!}>
        <label for="{{ $id }}" class="font-weight-normal">@lang($label ?? '')</label>
    </div>
</div>
