@if(empty($name))
<code>&lt;x-boilerplate::codemirror> The name attribute has not been set</code>
@else
<div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{!! isset($groupId) ? ' id="'.$groupId.'"' : '' !!}>
@isset($label)
    {!! Form::label($name, __($label)) !!}
@endisset
    <textarea id="{{ $id }}" name="{{ $name }}" style="visibility:hidden" rows="0">{!! old($name, $value ?? $slot ?? '') !!}</textarea>
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
@error($name)
    <div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
</div>
@include('boilerplate::load.async.codemirror', ['theme' => $theme])
@component('boilerplate::minify')
<script>
    whenAssetIsLoaded('CodeMirror', () => {
        let uid = getIntervalUid();
        intervals[uid] = setInterval(function() {
            if($('#{{ $id }}').is(':visible')){
                clearInterval(intervals[uid]);
                $('#{{ $id }}').codemirror({ {!! $options ?? '' !!} });
            }
        });
    })
</script>
@endcomponent
@endif