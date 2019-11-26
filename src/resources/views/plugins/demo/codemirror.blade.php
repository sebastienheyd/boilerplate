@include('boilerplate::load.codemirror', ['theme' => 'storm'])

@push('js')
    <script>
        $(function () {
            $('#code').codemirror();
        })
    </script>
@endpush

<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">CodeMirror</h3>
    </div>
    <div class="box-body">
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
    <div class="box-footer small text-muted text-right">
        <a href="https://codemirror.net/" target="_blank">CodeMirror</a>
    </div>
</div>
