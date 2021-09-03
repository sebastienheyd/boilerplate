@if(empty($name))
    <code>
        &lt;x-boilerplate::datepicker>
        The name attribute has not been set
    </code>
@else
    <div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{{ isset($groupId) ? ' id="'.$groupId.'"' : '' }}>
        @isset($label)
            {!! Form::label($name.'_localized', __($label)) !!}
        @endisset
        <div class="input-group" id="{{ $id }}" data-target-input="nearest">
            {!! Form::text($name.'_local', old($name.'_local', $value), array_merge(['data-toggle' => 'datetimepicker', 'data-target' => '#'.$id, 'class' => 'form-control datetimepicker-input'.$errors->first($name,' is-invalid').(isset($class) ? ' '.$class : '')], $attributes)) !!}
        </div>
        @if($help ?? false)
            <small class="form-text text-muted">@lang($help)</small>
        @endif
        @error($name)
        <div class="error-bubble"><div>{{ $message }}</div></div>
        @enderror
        {!! Form::hidden($name, $rawValue) !!}
</div>
@include('boilerplate::load.datepicker')
@push('js')
<script>
    $('#{{ $id }}').datetimepicker({
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
            $('input[name="{{ $name }}"]').val(date);
        }
    })
</script>
@endpush
@endif