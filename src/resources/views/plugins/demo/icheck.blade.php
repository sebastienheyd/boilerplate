@component('boilerplate::card', ['color' => 'success', 'title' => 'iCheck Bootstrap'])
    @slot('tools')
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
    @endslot
        <div class="row mb-3">
            <div class="col-12">
                Usage :
                <pre>
&lt;div class="icheck-primary d-inline">
    &lt;input type="checkbox" id="checkboxPrimary1">
    &lt;label for="checkboxPrimary1">&lt;/label>
&lt;/div></pre>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary1" checked>
                        <label for="checkboxPrimary1">
                        </label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary2">
                        <label for="checkboxPrimary2">
                        </label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkboxPrimary3" disabled>
                        <label for="checkboxPrimary3">
                            Primary checkbox
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary1" name="r1" checked>
                        <label for="radioPrimary1">
                        </label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary2" name="r1">
                        <label for="radioPrimary2">
                        </label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="radioPrimary3" name="r1" disabled>
                        <label for="radioPrimary3">
                            Primary radio
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group clearfix">
                    <div class="icheck-danger d-inline">
                        <input type="checkbox" checked id="checkboxDanger1">
                        <label for="checkboxDanger1">
                        </label>
                    </div>
                    <div class="icheck-danger d-inline">
                        <input type="checkbox" id="checkboxDanger2">
                        <label for="checkboxDanger2">
                        </label>
                    </div>
                    <div class="icheck-danger d-inline">
                        <input type="checkbox" disabled id="checkboxDanger3">
                        <label for="checkboxDanger3">
                            Danger checkbox
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group clearfix">
                    <div class="icheck-danger d-inline">
                        <input type="radio" name="r2" checked id="radioDanger1">
                        <label for="radioDanger1">
                        </label>
                    </div>
                    <div class="icheck-danger d-inline">
                        <input type="radio" name="r2" id="radioDanger2">
                        <label for="radioDanger2">
                        </label>
                    </div>
                    <div class="icheck-danger d-inline">
                        <input type="radio" name="r2" disabled id="radioDanger3">
                        <label for="radioDanger3">
                            Danger radio
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group clearfix">
                    <div class="icheck-success d-inline">
                        <input type="checkbox" checked id="checkboxSuccess1">
                        <label for="checkboxSuccess1">
                        </label>
                    </div>
                    <div class="icheck-success d-inline">
                        <input type="checkbox" id="checkboxSuccess2">
                        <label for="checkboxSuccess2">
                        </label>
                    </div>
                    <div class="icheck-success d-inline">
                        <input type="checkbox" disabled id="checkboxSuccess3">
                        <label for="checkboxSuccess3">
                            Success checkbox
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group clearfix">
                    <div class="icheck-success d-inline">
                        <input type="radio" name="r3" checked id="radioSuccess1">
                        <label for="radioSuccess1">
                        </label>
                    </div>
                    <div class="icheck-success d-inline">
                        <input type="radio" name="r3" id="radioSuccess2">
                        <label for="radioSuccess2">
                        </label>
                    </div>
                    <div class="icheck-success d-inline">
                        <input type="radio" name="r3" disabled id="radioSuccess3">
                        <label for="radioSuccess3">
                            Success radio
                        </label>
                    </div>
                </div>
            </div>
        </div>

    @slot('footer')
        <div class="text-right small text-muted">
            <a href="https://bantikyan.github.io/icheck-bootstrap/">iCheck Bootstrap</a>
        </div>
    @endslot
@endcomponent