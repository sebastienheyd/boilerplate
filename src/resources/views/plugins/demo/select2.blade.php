@include('boilerplate::load.select2')

@push('js')
<script>
    $(function() {
        $(".select2").select2();
    });
</script>
@endpush

<div class="card card-primary card-outline card-default">
    <div class="card-header border-bottom-0">
        <h3 class="card-title">Select2</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                Usage :
                <pre>
&commat;include('boilerplate::load.select2')
&commat;push('js')
    &lt;script>
        $('.select2').select2();
    &lt;/script>
&commat;endpush</pre>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Minimal</label>
                    <select class="form-control select2" style="width: 100%;">
                        <option selected="selected">Alabama</option>
                        <option>Alaska</option>
                        <option>California</option>
                        <option>Delaware</option>
                        <option>Tennessee</option>
                        <option>Texas</option>
                        <option>Washington</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Disabled</label>
                    <select class="form-control select2" disabled="disabled" style="width: 100%;">
                        <option selected="selected">Alabama</option>
                        <option>Alaska</option>
                        <option>California</option>
                        <option>Delaware</option>
                        <option>Tennessee</option>
                        <option>Texas</option>
                        <option>Washington</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Multiple</label>
                    <select class="form-control select2" multiple="multiple" data-placeholder="Multiple select" style="width: 100%;">
                        <option>Alabama</option>
                        <option>Alaska</option>
                        <option>California</option>
                        <option>Delaware</option>
                        <option>Tennessee</option>
                        <option>Texas</option>
                        <option>Washington</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Disabled Result</label>
                    <select class="form-control select2" style="width: 100%;">
                        <option selected="selected">Alabama</option>
                        <option>Alaska</option>
                        <option disabled="disabled">California (disabled)</option>
                        <option>Delaware</option>
                        <option>Tennessee</option>
                        <option>Texas</option>
                        <option>Washington</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer small text-muted text-right">
        <a href="https://select2.github.io/">select2</a>
    </div>
</div>
