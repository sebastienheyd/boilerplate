@php($options = ['Alabama', 'Alaska', 'Arizona', 'California', 'Delaware', 'Florida', 'Iowa', 'Oregon', 'Minnesota', 'Tennessee', 'Texas'])
@component('boilerplate::card', ['color' => 'primary', 'title' => 'Select2'])
    <div class="row">
        <div class="col-12">
            Usage :
            <pre>&lt;x-boilerplate::select2 name="example" label="Example" :options="['Opt 1', 'Opt 2']" /></pre>
        </div>
        <div class="col-md-6">
            @component('boilerplate::components.select2', ['label' => 'Minimal', 'name' => 'select2_dminimal', 'selected' => 1, 'options' => $options, 'allow-clear' => 'true', 'minimum-results-for-search' => 5])@endcomponent
        </div>
        <div class="col-md-6">
            @component('boilerplate::components.select2', ['label' => 'Multiple', 'name' => 'select2_multiple', 'selected' => [1,3], 'options' => $options, 'multiple' => true])@endcomponent
        </div>
    </div>
    @slot('footer')
        <div class="text-right small text-muted">
            <a href="https://sebastienheyd.github.io/boilerplate/components/select2" target="_blank">component</a> /
            <a href="https://sebastienheyd.github.io/boilerplate/plugins/select2" target="_blank">plugin</a> /
            <a href="https://select2.github.io/" target="_blank">select2</a>
        </div>
    @endslot
@endcomponent
