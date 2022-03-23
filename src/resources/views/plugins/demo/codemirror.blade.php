@component('boilerplate::card', ['color' => 'warning', 'title' => 'CodeMirror'])
        Usage :
        <pre>&lt;x-boilerplate::codemirror name="code">.color { color: red; }&lt;/x-boilerplate::codemirror></pre>
@component('boilerplate::codemirror', ['name' => 'code'])<h1>CodeMirror demo</h1>
<style>
    .color {
        color: red;
    }
</style>
<script>
    $(function () {
        alert('demo');
    });
</script>
@endcomponent
    @slot('footer')
        <div class="small text-muted text-right">
            <a href="https://sebastienheyd.github.io/boilerplate/components/codemirror" target="_blank">component</a> /
            <a href="https://sebastienheyd.github.io/boilerplate/plugins/codemirror" target="_blank">plugin</a> /
            <a href="https://codemirror.net/" target="_blank">CodeMirror</a>
        </div>
    @endslot
@endcomponent
