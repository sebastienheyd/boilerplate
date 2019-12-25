@include('boilerplate::load.codemirror', ['theme' => 'storm'])

@push('js')
    <script>
        $(function () {
            $('#code').codemirror();
        })
    </script>
@endpush

<div class="card card-outline card-green">
    <div class="card-header border-bottom-0">
        <h3 class="card-title">CodeMirror</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body pt-0">
        Usage :
        <pre>
&commat;include('boilerplate::load.codemirror', ['theme' => 'storm'])
&commat;push('js')
    &lt;script>
        var myCode = $('#code').codemirror();
        // To get the value : myCode.getValue();
    &lt;/script>
&commat;endpush</pre>
        <textarea id="code"><h1>CodeMirror demo</h1>
<style>
    .color {
        color: red;
    }
</style>
<script>
    $(function () {
        alert('demo');
    });
</script></textarea>
    </div>
    <div class="card-footer small text-muted text-right">
        <a href="https://codemirror.net/" target="_blank">CodeMirror</a>
    </div>
</div>
