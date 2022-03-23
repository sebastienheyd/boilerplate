@component('boilerplate::card', ['color' => 'success', 'title' => 'iCheck Bootstrap'])
        <div class="row mb-3">
            <div class="col-12">
                Usage :
                <pre>&lt;x-boilerplate::icheck name="checkbox" label="My checkbox" /></pre>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 d-flex">
                @component('boilerplate::icheck', ['name' => 'c1', 'label' => '', 'class' => 'mb-0', 'checked' => true])@endcomponent
                @component('boilerplate::icheck', ['name' => 'c1', 'label' => '', 'class' => 'mb-0'])@endcomponent
                @component('boilerplate::icheck', ['name' => 'c1', 'label' => 'Primary checkbox', 'class' => 'mb-0', 'disabled' => true])@endcomponent
            </div>
            <div class="col-sm-6 d-flex">
                @component('boilerplate::icheck', ['name' => 'r1', 'type' => 'radio', 'label' => '', 'class' => 'mb-0', 'checked' => true])@endcomponent
                @component('boilerplate::icheck', ['name' => 'r1', 'type' => 'radio', 'label' => '', 'class' => 'mb-0'])@endcomponent
                @component('boilerplate::icheck', ['name' => 'r1', 'type' => 'radio', 'label' => 'Primary checkbox', 'class' => 'mb-0', 'disabled' => true])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 d-flex">
                @component('boilerplate::icheck', ['name' => 'c2', 'color' => 'danger', 'label' => '', 'class' => 'mb-0', 'checked' => true])@endcomponent
                @component('boilerplate::icheck', ['name' => 'c2', 'color' => 'danger', 'label' => '', 'class' => 'mb-0'])@endcomponent
                @component('boilerplate::icheck', ['name' => 'c2', 'color' => 'danger', 'label' => 'Primary checkbox', 'class' => 'mb-0', 'disabled' => true])@endcomponent
            </div>
            <div class="col-sm-6 d-flex">
                @component('boilerplate::icheck', ['name' => 'r2', 'color' => 'danger', 'type' => 'radio', 'label' => '', 'class' => 'mb-0', 'checked' => true])@endcomponent
                @component('boilerplate::icheck', ['name' => 'r2', 'color' => 'danger', 'type' => 'radio', 'label' => '', 'class' => 'mb-0'])@endcomponent
                @component('boilerplate::icheck', ['name' => 'r2', 'color' => 'danger', 'type' => 'radio', 'label' => 'Primary checkbox', 'class' => 'mb-0', 'disabled' => true])@endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 d-flex">
                @component('boilerplate::icheck', ['name' => 'c3', 'color' => 'success', 'label' => '', 'class' => 'mb-0', 'checked' => true])@endcomponent
                @component('boilerplate::icheck', ['name' => 'c3', 'color' => 'success', 'label' => '', 'class' => 'mb-0'])@endcomponent
                @component('boilerplate::icheck', ['name' => 'c3', 'color' => 'success', 'label' => 'Primary checkbox', 'class' => 'mb-0', 'disabled' => true])@endcomponent
            </div>
            <div class="col-sm-6 d-flex">
                @component('boilerplate::icheck', ['name' => 'r3', 'color' => 'success', 'type' => 'radio', 'label' => '', 'class' => 'mb-0', 'checked' => true])@endcomponent
                @component('boilerplate::icheck', ['name' => 'r3', 'color' => 'success', 'type' => 'radio', 'label' => '', 'class' => 'mb-0'])@endcomponent
                @component('boilerplate::icheck', ['name' => 'r3', 'color' => 'success', 'type' => 'radio', 'label' => 'Primary checkbox', 'class' => 'mb-0', 'disabled' => true])@endcomponent
            </div>
        </div>

    @slot('footer')
        <div class="text-right small text-muted">
            <a href="https://sebastienheyd.github.io/boilerplate/components/icheck" target="_blank">component</a> /
            <a href="https://bantikyan.github.io/icheck-bootstrap/" target="_blank">iCheck</a>
        </div>
    @endslot
@endcomponent