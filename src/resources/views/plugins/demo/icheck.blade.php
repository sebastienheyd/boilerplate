@component('boilerplate::card', ['color' => 'success', 'title' => 'iCheck Bootstrap'])
        <div class="row mb-3">
            <div class="col-12">
                Usage :
                <pre>&lt;x-boilerplate::icheck name="checkbox" label="My checkbox" /></pre>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 d-flex">
                <x-boilerplate::icheck name="c1" label="" class="mb-0" checked />
                <x-boilerplate::icheck name="c1" label="" class="mb-0" />
                <x-boilerplate::icheck name="c1" label="Primary checkbox" class="mb-0" disabled />
            </div>
            <div class="col-sm-6 d-flex">
                <x-boilerplate::icheck name="r1" type="radio" label="" class="mb-0" checked />
                <x-boilerplate::icheck name="r1" type="radio" label="" class="mb-0" />
                <x-boilerplate::icheck name="r1" type="radio" label="Primary radio" class="mb-0" disabled />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 d-flex">
                <x-boilerplate::icheck color="danger" name="c2" label="" class="mb-0" checked />
                <x-boilerplate::icheck color="danger" name="c2" label="" class="mb-0" />
                <x-boilerplate::icheck color="danger" name="c2" label="Danger checkbox" class="mb-0" disabled />
            </div>
            <div class="col-sm-6 d-flex">
                <x-boilerplate::icheck color="danger" name="r2" type="radio" label="" class="mb-0" checked />
                <x-boilerplate::icheck color="danger" name="r2" type="radio" label="" class="mb-0" />
                <x-boilerplate::icheck color="danger" name="r2" type="radio" label="Danger radio" class="mb-0" disabled />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 d-flex">
                <x-boilerplate::icheck color="success" name="c3" label="" class="mb-0" checked />
                <x-boilerplate::icheck color="success" name="c3" label="" class="mb-0" />
                <x-boilerplate::icheck color="success" name="c3" label="Danger checkbox" class="mb-0" disabled />
            </div>
            <div class="col-sm-6 d-flex">
                <x-boilerplate::icheck color="success" name="r3" type="radio" label="" class="mb-0" checked />
                <x-boilerplate::icheck color="success" name="r3" type="radio" label="" class="mb-0" />
                <x-boilerplate::icheck color="success" name="r3" type="radio" label="Danger radio" class="mb-0" disabled />
            </div>
        </div>

    @slot('footer')
        <div class="text-right small text-muted">
            <a href="https://sebastienheyd.github.io/boilerplate/components/icheck" target="_blank">component</a> /
            <a href="https://bantikyan.github.io/icheck-bootstrap/" target="_blank">iCheck</a>
        </div>
    @endslot
@endcomponent