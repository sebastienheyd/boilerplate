@component('boilerplate::card', ['color' => 'info', 'title' => 'TinyMCE'])
        Usage :
        <pre>
&commat;include('boilerplate::load.tinymce')
&commat;push('js')
    &lt;script>
        $('#tiny').tinymce({});
    &lt;/script>
&commat;endpush</pre>
    @component('boilerplate::tinymce') @endcomponent
    @slot('footer')
        <div class="text-muted small text-right">
            <a href="https://www.tiny.cloud/docs/" target="_blank">tinyMCE</a>
        </div>
    @endslot
@endcomponent
