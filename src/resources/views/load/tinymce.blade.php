@if(!defined('LOAD_TINYMCE'))
    @push('js')
        <script src="{!! mix('/js/tinymce/tinymce.min.js', '/assets/vendor/boilerplate') !!}"></script>
        <script>
            tinymce.defaultSettings = {
                plugins: "autoresize fullscreen codemirror link lists table media image imagetools customalign",
                toolbar: "undo redo | styleselect | bold italic underline | customalignleft aligncenter customalignright | link media image | bullist numlist outdent indent | table | code fullscreen",
                codemirror: { config: { theme: 'storm' } },
                menubar: false,
                removed_menuitems: 'newdocument',
                remove_linebreaks: false,
                forced_root_block: false,
                verify_html: false,
                branding: false,
                statusbar: false,
                browser_spellcheck: true,
                encoding: 'UTF-8',
                image_uploadtab: false,
                @if(config('boilerplate.app.locale') !== 'en')
                language: '{{ config('boilerplate.app.locale') }}'
                @endif
            };
        </script>
    @endpush
    @php(define('LOAD_TINYMCE', true))
@endif
