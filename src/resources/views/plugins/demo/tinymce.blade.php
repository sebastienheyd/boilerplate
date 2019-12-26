@include('boilerplate::load.tinymce')

@push('js')
    <script>
        $(function() {
            $('#tiny').tinymce({});
        })
    </script>
@endpush

@component('boilerplate::card', ['color' => 'info', 'title' => 'TinyMCE'])
    @slot('tools')
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
    @endslot
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

    @slot('footer')
        <div class="text-muted small text-right">
            <a href="https://www.tiny.cloud/docs/" target="_blank">tinyMCE</a>
        </div>
    @endslot
@endcomponent
