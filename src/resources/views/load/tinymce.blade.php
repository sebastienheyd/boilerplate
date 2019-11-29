@if(!defined('LOAD_TINYMCE'))
    @push('js')
        <script src="{!! mix('/js/tinymce/tinymce.min.js', '/assets/vendor/boilerplate') !!}"></script>
        <script>
            tinymce.defaultSettings = {
                plugins: "autoresize fullscreen codemirror link lists table media image imagetools",
                toolbar: "code fullscreen | undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | table | bullist numlist outdent indent | link media image",
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
                @if(config('boilerplate.app.locale') !== 'en')
                language: '{{ config('boilerplate.app.locale') }}'
                @endif
            };
        </script>
    @endpush
    @php(define('LOAD_TINYMCE', true))
@endif
