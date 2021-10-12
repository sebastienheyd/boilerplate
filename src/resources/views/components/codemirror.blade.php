@if(empty($name))
<code>&lt;x-boilerplate::codemirror> The name attribute has not been set</code>
@else
<div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{!! isset($groupId) ? ' id="'.$groupId.'"' : '' !!}>
@isset($label)
    {!! Form::label($name, __($label)) !!}
@endisset
    <textarea id="{{ $id }}" name="{{ $name }}" style="visibility:hidden">{!! old($name, $value ?? $slot ?? '') !!}</textarea>
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
@error($name)
    <div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
</div>
@include('boilerplate::load.codemirror', ['theme' => $theme])
@push('js')
    <script>$(function(){$('#{{ $id }}').codemirror({ {!! $options ?? '' !!} })});</script>
@endpush
@endif