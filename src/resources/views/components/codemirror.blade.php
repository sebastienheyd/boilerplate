@if(empty($name))
<code>&lt;x-boilerplate::codemirror> The name attribute has not been set</code>
@else
<div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{!! isset($groupId) ? ' id="'.$groupId.'"' : '' !!}>
@isset($label)
    <label for="{{ $id }}">{!! __($label) !!}</label>
@endisset
    <textarea id="{{ $id }}" name="{{ $name }}" style="visibility:hidden" rows="0">{!! old($name, $value ?? $slot ?? '') !!}</textarea>
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
@error($nameDot)
    <div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
</div>
@include('boilerplate::load.async.codemirror', ['js' => $js ?? []])
@component('boilerplate::minify')
<script>
    whenAssetIsLoaded('CodeMirror', () => {
        let uid = getIntervalUid();
        intervals[uid] = setInterval(function() {
            if($('#{{ $id }}').is(':visible')){
                clearInterval(intervals[uid]);
                window.{{ 'CM_'.\Str::camel($id) }} = $('#{{ $id }}').codemirror({ {!! $options ?? '' !!} });
            }
        });
    })
</script>
@endcomponent
@endif