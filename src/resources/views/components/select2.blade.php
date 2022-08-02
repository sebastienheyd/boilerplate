@if(empty($name))
<code>&lt;x-boilerplate::select2> The name attribute has not been set</code>
@else
<div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{!! isset($groupId) ? ' id="'.$groupId.'"' : '' !!}>
@isset($label)
    <label for="{{ $id }}">{!! __($label) !!}</label>
@endisset
    <select id="{{ $id }}" name="{{ $name }}" class="form-control{{ $errors->first($nameDot,' is-invalid') }}{{ isset($class) ? ' '.$class : '' }}"{!! !empty($attributes) ? ' '.$attributes : '' !!} style="visibility:hidden;height:1rem" autocomplete="off">
@if(!isset($multiple))
        <option></option>
@endif
@if(!empty($options) && is_array($options))
@foreach($options as $k => $v)
        <option value="{{ $k }}"{{ collect($selected ?? [])->contains($k) ? ' selected' : '' }}>{{ $v }}</option>
@endforeach
@else
        {{ $slot }}
@endisset
    </select>
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
@error($nameDot)
    <div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
</div>
@include('boilerplate::load.async.select2')
@component('boilerplate::minify')
    <script>
        whenAssetIsLoaded('select2', () => {
            window.{{ 'S2_'.\Str::camel($id) }} = $('#{{ $id }}').select2({
                placeholder: '{{ $placeholder ?? '—' }}',
                allowClear: {{ $allowClear }},
                language: "{{ App::getLocale() }}",
                direction: "@lang('boilerplate::layout.direction')",
                minimumInputLength: {{ $minimumInputLength ?? intval(isset($model)) }},
                minimumResultsForSearch: {{ $minimumResultsForSearch ?? 10 }},
                width: '100%',
                dropdownAutoWidth: true,
                dropdownParent: $('#{{ $id }}').parent(),
                tags: {{ $tags ?? 0 }},
                escapeMarkup: function(markup) { return markup },
                @isset($ajax)
                ajax: {
                    delay: 200,
                    url: '{{ $ajax }}',
                    data: function (param) {
                        return {
                            q: param.term,
                            length: {{ $maxLength ?? 10 }},
                            @isset($model)
                            m: "{{ $model }}",
                            @endisset
                            @if(!empty($ajaxParams))
                            @foreach ($ajaxParams as $k => $v)
                            {{ $k }}: "{{ $v }}",
                            @endforeach
                            @endif
                        }
                    },
                    method: 'post'
                }
                @endisset
            })
        })
    </script>
@endcomponent
@endif
