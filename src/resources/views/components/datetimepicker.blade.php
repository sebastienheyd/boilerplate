@if(empty($name))
<code>&lt;x-boilerplate::datetimepicker> The name attribute has not been set</code>
@else
<div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{!! isset($groupId) ? ' id="'.$groupId.'"' : '' !!}>
@isset($label)
    <label>{!! __($label) !!}</label>
@endisset
    <div class="input-group" id="{{ $id }}" data-target-input="nearest">
@if($prepend || $prependText)
        <div class="input-group-prepend" data-toggle="datetimepicker" data-target="#{{ $id }}">
@if($prepend)
            {!! $prepend !!}
@else
            <span class="input-group-text">{!! $prependText !!}</span>
@endif
        </div>
@endif
        {{ html()->input('text')->name($name.'_local')->value(old($name.'_local', $value))->attributes(array_merge(['data-toggle' => 'datetimepicker', 'data-target' => '#'.$id, 'class' => 'form-control datetimepicker-input'.$errors->first($nameDot,' is-invalid').(isset($class) ? ' '.$class : ''), 'autocomplete' => 'off'], $attributes)) }}
@if($append || $appendText)
        <div class="input-group-append" data-toggle="datetimepicker" data-target="#{{ $id }}">
@if($append)
            {!! $append !!}
@else
            <span class="input-group-text">{!! $appendText !!}</span>
@endif
        </div>
@endif
    </div>
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
@error($nameDot)
    <div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
    {{ html()->input('hidden')->name($name)->value($rawValue) }}
</div>
@include('boilerplate::load.async.datepicker')
@component('boilerplate::minify')
<script>
    whenAssetIsLoaded('datetimepicker', () => {
        window.{{ 'DTP_'.\Str::camel($id) }} = $('#{{ $id }}').datetimepicker({
            format: "{{ $format }}",
            buttons: {
                showToday: {{ $showToday ?? 'false' }},
                showClear: {{ $showClear ?? 'false' }},
                showClose: {{ $showClose ?? 'false' }}
            },
            useCurrent: {{ $useCurrent ?? 'false' }},
            {!! $options ?? '' !!}
        });

        $('#{{ $id }}').on('change.datetimepicker', () => {
            $('input[name="{{ $name }}"]').val('');
            if ($('input[name="{{ $name }}_local"]').val() !== '') {
                let date = $('#{{ $id }}').datetimepicker('viewDate').format('{{ $format === 'L' ? 'YYYY-MM-DD' : 'YYYY-MM-DD HH:mm:ss' }}');
                $('input[name="{{ $name }}"]').val(date).trigger('change');
            }
        });
    });
</script>
@endcomponent
@endif