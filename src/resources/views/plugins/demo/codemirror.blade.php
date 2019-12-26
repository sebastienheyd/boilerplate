@include('boilerplate::load.codemirror', ['theme' => 'storm'])

@push('js')
    <script>
        $(function () {
            $('#code').codemirror();
        })
    </script>
@endpush

@component('boilerplate::card', ['color' => 'warning', 'title' => 'CodeMirror'])
    @slot('tools')
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
    @endslot
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
</script>
</textarea>

    @slot('footer')
        <div class="small text-muted text-right">
            <a href="https://codemirror.net/" target="_blank">CodeMirror</a>
        </div>
    @endslot
@endcomponent
