@include('boilerplate::load.tinymce')

@push('js')
    <script>
        $(function() {
            $('#tiny').tinymce({});
        })
    </script>
@endpush

<div class="card card-outline card-info">
    <div class="card-header border-bottom-0">
        <h3 class="card-title">TinyMCE</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body pt-0">
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
    <div class="card-footer text-sm text-right">
        <a href="https://www.tiny.cloud/docs/" target="_blank">tinyMCE</a>
    </div>
</div>
