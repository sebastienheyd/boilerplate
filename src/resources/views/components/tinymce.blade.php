@if(empty($name))
<code>&lt;x-boilerplate::tinymce>The name attribute has not been set</code>
@else
<div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{!! isset($groupId) ? ' id="'.$groupId.'"' : '' !!}>
@isset($label)
    <label for="{{ $id }}">{!! __($label) !!}</label>
@endisset
    <textarea id="{{ $id }}" name="{{ $name }}"{!! !empty($attributes) ? ' '.$attributes : '' !!} style="visibility:hidden{{ $minHeight ?? false ? ';min-height:'.$minHeight.'px' : '' }}">{!! old($name, $value ?? $slot ?? '') !!}</textarea>
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
@error($nameDot)
    <div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
</div>
@include('boilerplate::load.async.tinymce')
@component('boilerplate::minify')
<script>
    whenAssetIsLoaded('{!! mix('/plugins/tinymce/tinymce.min.js', '/assets/vendor/boilerplate') !!}', () => {
        window.{{ 'MCE_'.\Str::camel($id) }} = tinymce.init({
            selector: '#{{ $id }}',
            toolbar_sticky: {{ ($sticky ?? false) ? 'true' : 'false' }},
            {{ $minHeight ?? false ? 'min_height:'.$minHeight.',' : '' }}
            {{ $maxHeight ?? false ? 'max_height:'.$maxHeight.',' : '' }}
        });
    });
</script>
@endcomponent
@endif
