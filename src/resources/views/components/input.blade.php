@if(empty($name))
<code>
    &lt;x-boilerplate::input>
    The name attribute has not been set
</code>
@else
<div class="form-group">
    {{ Form::label($name, $label ?? '' ? __($label) : mb_convert_case($name, MB_CASE_TITLE)) }}
@if($type === 'password')
    {{ Form::password($name, array_merge(['class' => 'form-control'.$errors->first($name,' is-invalid').(isset($class) ? ' '.$class : '')], $attributes)) }}{!! $errors->first($name, PHP_EOL.'    <div class="error-bubble"><div>:message</div></div>') !!}
@elseif($type === 'file')
    {{ Form::file($name, array_merge(['class' => 'form-control-file'.$errors->first($name,' is-invalid').(isset($class) ? ' '.$class : '')], $attributes)) }}{!! $errors->first($name, PHP_EOL.'    <div class="error-bubble"><div>:message</div></div>') !!}
@elseif($type === 'select')
    {{ Form::select($name, $options ?? [], old($name, $value ?? ''), array_merge(['class' => 'form-control-file'.$errors->first($name,' is-invalid').(isset($class) ? ' '.$class : '')], $attributes)) }}{!! $errors->first($name, PHP_EOL.'    <div class="error-bubble"><div>:message</div></div>') !!}
@else
    {{ Form::{$type ?? 'text'}($name, old($name, $value ?? ''), array_merge(['class' => 'form-control'.$errors->first($name,' is-invalid').(isset($class) ? ' '.$class : '')], $attributes)) }}{!! $errors->first($name, PHP_EOL.'    <div class="error-bubble"><div>:message</div></div>') !!}
@endif
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
</div>
@endif