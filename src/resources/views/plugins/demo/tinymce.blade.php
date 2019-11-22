@include('boilerplate::load.tinymce')

@push('js')
    <script>
        $(function() {
            $('#tiny').tinymce({});
        })
    </script>
@endpush

<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">TinyMCE</h3>
    </div>
    <div class="box-body">
        Usage :
        <pre>
&commat;include('boilerplate::load.tinymce')
&commat;push('js')
    &lt;script>
        $('#tiny').tinymce({});
    &lt;/script>
&commat;endpush</pre>
        <textarea id="tiny">
            <h1>TinyMCE demo</h1>
        </textarea>
    </div>
    <div class="box-footer small text-muted text-right">
        <a href="https://www.tiny.cloud/docs/" target="_blank">tinyMCE</a>
    </div>
</div>
