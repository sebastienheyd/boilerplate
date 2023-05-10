@if(empty($name))
<code>
    &lt;x-boilerplate::input>
    The name attribute has not been set
</code>
@else
@if($type !== 'hidden')
<div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{!! isset($groupId) ? ' id="'.$groupId.'"' : '' !!}>
@isset($label)
    <label>{!! __($label) !!}</label>
@endisset
@if($prepend || $prependText || $append || $appendText)
    <div class="input-group{{ isset($inputGroupClass) ? ' '.$inputGroupClass : '' }}">
@endif
@endif
@if($prepend || $prependText)
        <div class="input-group-prepend">
@if($prepend)
            {!! $prepend !!}
@else
            <span class="input-group-text">{!! $prependText !!}</span>
@endif
        </div>
@endif
@if($type === 'password')
    {!! html()->input('password')->name($name)->class('form-control'.$errors->first($nameDot,' is-invalid').(isset($class) ? ' '.$class : ''))->attributes($attributes) !!}
@elseif($type === 'file')
    {!! html()->input('file')->name($name)->class('form-control-file'.$errors->first($nameDot,' is-invalid').(isset($class) ? ' '.$class : ''))->attributes($attributes) !!}
@elseif($type === 'textarea')
    {!! html()->textarea()->name($name)->value(old($name, $value ?? ''))->class('form-control'.$errors->first($nameDot,' is-invalid').(isset($class) ? ' '.$class : ''))->attributes($attributes) !!}
@elseif($type === 'select')
    {!! html()->select(null, $options ?? [], old($name, $value ?? ''))->name($name)->class('form-control'.$errors->first($nameDot,' is-invalid').(isset($class) ? ' '.$class : ''))->attributes($attributes) !!}
@else
@if($clearable ?? false)
    <div class="input-clearable">
    <span class="fa fa-times fa-xs"{!! old($name, $value ?? '') !== '' ? ' style="display:block"' : '' !!}></span>
@endif
    {!! html()->input($type)->name($name)->value(old($name, $value ?? ''))->class('form-control'.$errors->first($nameDot,' is-invalid').(isset($class) ? ' '.$class : ''))->attributes($attributes) !!}
@if($clearable ?? false)
    </div>
@endif
@endif
@if($append || $appendText)
        <div class="input-group-append">
@if($append)
            {!! $append !!}
@else
            <span class="input-group-text">{!! $appendText !!}</span>
@endif
        </div>
@endif
@if($prepend || $prependText || $append || $appendText)
    </div>
@endif
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
@error($nameDot)
    <div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
@if($type !== 'hidden')
</div>
@endif
@endif
