@if(empty($name))
<code>
    &lt;x-boilerplate::select2>
    The name attribute has not been set
</code>
@else
<div class="form-group">
@isset($label)
    {{ Form::label($name, __($label)) }}
@endisset
    <select id="{{ $id }}" name="{{ $name }}" class="form-control{{ $errors->first($name,' is-invalid') }}{{ isset($class) ? ' '.$class : '' }}"{!! !empty($attributes) ? ' '.$attributes : '' !!}>
@if(!isset($multiple))
        <option></option>
@endif
        {{ $slot }}
    </select>
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
@error($name)
    <div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
</div>
@include('boilerplate::load.select2')
@push('js')
    <script>
        $(function () {
            $('#{{ $id }}').select2({
                placeholder: '{{ $placeholder ?? '—' }}',
                allowClear: {{ $allowClear }},
                language: "{{ config('boilerplate.app.locale') }}",
                direction: "@lang('boilerplate::layout.direction')",
                minimumInputLength: {{ $minimumInputLength ?? 0 }},
                minimumResultsForSearch: {{ $minimumResultsForSearch ?? 0 }},
                width: '100%',
@isset($ajax)
                ajax: {
                    delay: 200,
                    url: '{{ $ajax }}',
                    method: 'post'
                }
@endisset
            });
        });
    </script>
@endpush
@endif