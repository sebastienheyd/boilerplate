@component('boilerplate::card', ['color' => 'indigo', 'title' => 'Colorpicker'])
    Usage
    <pre>&lt;x-boilerplate::colorpicker name="color" /></pre>
    <div class="row">
        <div class="col-6">
            @component('boilerplate::components.colorpicker', ['name' => 'color'])@endcomponent()
        </div>
        <div class="col-6">
            @component('boilerplate::components.colorpicker', ['name' => 'color2', 'value' => '#28a745'])@endcomponent()
        </div>
    </div>
    @slot('footer')
        <div class="text-right small text-muted">
            <a href="https://sebastienheyd.github.io/boilerplate/components/colorpicker" target="_blank">component</a> /
            <a href="https://seballot.github.io/spectrum" target="_blank">Spectrum colorpicker</a>
        </div>
    @endslot
@endcomponent
