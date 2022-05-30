@if(empty($name))
    <code>&lt;x-boilerplate::colorpicker> The name attribute has not been set</code>
@else
<div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{!! isset($groupId) ? ' id="'.$groupId.'"' : '' !!}>
@isset($label)
    <label>{!! __($label) !!}</label>
@endisset
    {!! Form::text($name, old($name, $value ?? null), array_merge([
        'id' => $id,
        'class' => trim($errors->first($name,' is-invalid').(isset($class) ? ' form-control '.$class : 'form-control')),
        'autocomplete' => 'off',
    ], $attributes)) !!}
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
@error($nameDot)
    <div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
</div>
@include('boilerplate::load.async.colorpicker')
@component('boilerplate::minify')
    <script>
        whenAssetIsLoaded('ColorPicker', () => {
            window.{{ 'CP_'.\Str::camel($id) }} = $('#{{ $id }}').spectrum({
                allowEmpty:true,
                showInput: true,
                showInitial: true,
                clickoutFiresChange: false,
                locale: '{{ App::getLocale() }}',
                showSelectionPalette: false,
                @if(isset($palette) && is_array($palette) && !empty($palette))
                palette: {!! json_encode($palette) !!},
                @endif
                @if(isset($selectionPalette) && is_array($selectionPalette) && !empty($selectionPalette))
                selectionPalette: {!! json_encode(array_reverse($selectionPalette)) !!},
                @endif
                {!! $options ?? '' !!}
            })
        });
    </script>
@endcomponent
@endif

