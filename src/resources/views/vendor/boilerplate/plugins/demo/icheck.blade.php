@include('boilerplate::load.icheck')

<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">iCheck - Checkbox &amp; Radio</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        Usage :
        <pre>
&commat;include('boilerplate::load.icheck')
&ltinput type="checkbox" class="icheck">
</pre>

        <!-- checkbox -->
        <div class="form-group">
            <label>
                <input type="checkbox" class="icheck" checked>
            </label>
            <label>
                <input type="checkbox" class="icheck">
            </label>
            <label>
                <input type="checkbox" class="icheck" disabled>
                Checkbox
            </label>
        </div>

        <!-- radio -->
        <div class="form-group">
            <label>
                <input type="radio" name="r1" class="icheck" checked>
            </label>
            <label>
                <input type="radio" name="r1" class="icheck">
            </label>
            <label>
                <input type="radio" name="r1" class="icheck" disabled>
                Radio
            </label>
        </div>

    </div>
</div>