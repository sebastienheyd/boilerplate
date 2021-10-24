@if(empty($name))
<code>&lt;x-boilerplate::tinymce>The name attribute has not been set</code>
@else
<div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{!! isset($groupId) ? ' id="'.$groupId.'"' : '' !!}>
@isset($label)
    {!! Form::label($name, __($label)) !!}
@endisset
    <textarea id="{{ $id }}" name="{{ $name }}"{!! !empty($attributes) ? ' '.$attributes : '' !!} style="visibility:hidden">{!! old($name, $value ?? $slot ?? '') !!}</textarea>
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
@error($name)
    <div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
</div>
@includeWhen($hasMediaManager, 'boilerplate-media-manager::load.tinymce')
@includeUnless($hasMediaManager, 'boilerplate::load.tinymce')
@component('boilerplate::minify')
<script id="interval_{{$id}}">
    var interval_{{$id}} = setInterval(function() {
        if(typeof tinymce !== 'undefined') {
            $('#{{ $id }}').tinymce({
                toolbar_sticky: {{ ($sticky ?? false) ? 'true' : 'false' }},
            });
            clearInterval(interval_{{$id}});
            document.getElementById('interval_{{$id}}').remove();
        }
    }, 1);
</script>
@endcomponent
@endif