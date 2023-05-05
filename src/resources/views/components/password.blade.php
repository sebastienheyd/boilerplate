@if(empty($name))
<code>
    &lt;x-boilerplate::password>
    The name attribute has not been set
</code>
@else
<div class="form-group{{ isset($groupClass) ? ' '.$groupClass : '' }}"{!! isset($groupId) ? ' id="'.$groupId.'"' : '' !!}>
@isset($label)
    <label>{!! __($label) !!}</label>
@endisset
    <div class="input-group password">
        {{ html()->input('password')->name($name)->class('form-control'.$errors->first($nameDot,' is-invalid').(isset($class) ? ' '.$class : ''))->attributes($attributes) }}
        <div class="input-group-append">
            <button type="button" class="btn" data-toggle="password" tabindex="-1"><i class="far fa-fw fa-eye"></i></button>
        </div>
    </div>
@if($help ?? false)
    <small class="form-text text-muted">@lang($help)</small>
@endif
@error($nameDot)
    <div class="error-bubble"><div>{{ $message }}</div></div>
@enderror
</div>
@endif
@if($check)
@push('js')
@component('boilerplate::minify')
<script>
    $(() => {
        var {{ $name }}_el = $('input[name="{{ $name }}"]');
        var {{ $name }}_ppv = {{ $name }}_el.popover({
            title: "{{ ucfirst(__('boilerplate::password.requirements')) }}",
            content: '',
            placement: 'bottom',
            trigger: 'manual',
            html: true
        });

        {{ $name }}_el.on('keyup focus', function() {
            let er = [];

            $.map([
                [/.{{!! $length !!},}/, "{{ __('boilerplate::password.length', ['nb' => $length]) }}"],
                [/[a-z]+/, "{{ __('boilerplate::password.letter') }}"],
                [/[0-9]+/, "{{ __('boilerplate::password.number') }}"],
                [/[A-Z]+/, "{{ __('boilerplate::password.capital') }}"],
                [/[^A-Za-z0-9]+/, "{{ __('boilerplate::password.special') }}"]
            ], function(rule) {
                if(!{{ $name }}_el.val().match(rule[0])) {
                    er.push(rule[1]);
                }
            });

            if(er.length > 0) {
                {{ $name }}_el.data('bs.popover').config.content = er.join('<br>');
                {{ $name }}_ppv.popover('show');
            } else {
                {{ $name }}_ppv.popover('hide');
            }
        }).on('blur', () => {
            {{ $name }}_ppv.popover('hide');
        });
    });
</script>
@endcomponent
@endpush
@endif