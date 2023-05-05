@if(empty($name))
<code>&lt;x-boilerplate::daterangepicker> The name attribute has not been set</code>
@else
<div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{!! isset($groupId) ? ' id="'.$groupId.'"' : '' !!}>
@isset($label)
    <label>{!! __($label) !!}</label>
@endisset
    <div class="input-group" id="{{ $id }}">
@if($prepend || $prependText)
        <div class="input-group-prepend">
@if($prepend)
            {!! $prepend !!}
@else
            <span class="input-group-text">{!! $prependText !!}</span>
@endif
        </div>
@endif
        <div class="d-flex align-items-center form-control{{ isset($controlClass) ? ' '.$controlClass : '' }}">
            {{ html()->input('text')->name($name.'[value]')->value(old($name.'.value'))->attributes(array_merge(['autocomplete' => 'off', 'class' => 'daterangepicker-input'.$errors->first($nameDot,' is-invalid').$errors->first($nameDot.'.start',' is-invalid').$errors->first($nameDot.'.end',' is-invalid').(isset($class) ? ' '.$class : '')], $attributes)) }}
            <span class="fa fa-fw fa-times fa-xs ml-1 clear-daterangepicker" data-name="{{ $name }}" style="display:none"/>
        </div>
@if($append || $appendText)
        <div class="input-group-append">
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
@error($nameDot.'.start')
<div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
@error($nameDot.'.end')
<div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
    {{ html()->input('hidden')->name($name.'[start]')->value(old($name.'[start]', $start ?? ''))->attributes(['autocomplete' => 'off']) }}
    {{ html()->input('hidden')->name($name.'[end]')->value(old($name.'[end]', $start ?? ''))->attributes(['autocomplete' => 'off']) }}
</div>
@include('boilerplate::load.async.daterangepicker')
@component('boilerplate::minify')
<script>
    whenAssetIsLoaded('daterangepicker', () => {
        window.{{ 'DRP_'.\Str::camel($id) }} = $('input[name="{{ $name }}[value]"]').daterangepicker({
            showDropdowns: true,
            opens: "{{ $alignment ?? 'right' }}",
            @if(!empty($minDate))
            minDate: moment('{{ $minDate }}'),
            @endif
            @if(!empty($maxDate))
            maxDate: moment('{{ $maxDate }}'),
            @endif
            timePicker: {{ bool($timePicker ?? false) ? 'true' : 'false' }},
            timePickerIncrement: {{ $timePickerIncrement ?? '1' }},
            timePicker24Hour: {{ bool($timePicker24Hour ?? true) ? 'true' : 'false' }},
            timePickerSeconds: {{ bool($timePickerSeconds ?? false) ? 'true' : 'false' }},
            autoUpdateInput: {{ (($start ?? null) || ($end ?? null)) ? 'true' : 'false' }},
            startDate: {!! !empty(old($name.'.start', $start ?? '')) ? 'moment("'.old($name.'.start', $start ?? '').'")' : 'moment()' !!},
            endDate: {!! !empty(old($name.'.end', $end ?? '')) ? 'moment("'.old($name.'.end', $end ?? '').'")' : 'moment()' !!},
            locale: { format: '{{ $format }}' }
        }).on('apply.daterangepicker', applyDateRangePicker);
    });
</script>
@endcomponent
@endif