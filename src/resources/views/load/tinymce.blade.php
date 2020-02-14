@if(!defined('LOAD_TINYMCE'))
    @push('js')
        <script src="{!! mix('/js/tinymce/tinymce.min.js', '/assets/vendor/boilerplate') !!}"></script>
        <script>
            tinymce.defaultSettings = {
                plugins: "autoresize fullscreen codemirror link lists table media image imagetools paste customalign stickytoolbar",
                toolbar: "undo redo | styleselect | bold italic underline | customalignleft aligncenter customalignright | link media image | bullist numlist | table | code fullscreen",
                contextmenu: "link image imagetools table spellchecker bold italic underline",
                sticky_toolbar_container: '.tox-editor-header',
                toolbar_drawer: "sliding",
                sticky_offset: $('nav.main-header').outerHeight(),
                codemirror: { config: { theme: 'storm' } },
                menubar: false,
                removed_menuitems: 'newdocument',
                remove_linebreaks: false,
                forced_root_block: false,
                force_p_newlines: true,
                relative_urls: false,
                verify_html: false,
                branding: false,
                statusbar: false,
                browser_spellcheck: true,
                encoding: 'UTF-8',
                image_uploadtab: false,
                paste_preprocess: function(plugin, args) {
                    args.content = args.content.replace(/<(\/)*(\\?xml:|meta|link|span|font|del|ins|st1:|[ovwxp]:)((.|\s)*?)>/gi, ''); // Unwanted tags
                    args.content = args.content.replace(/\s(class|style|type|start)=("(.*?)"|(\w*))/gi, ''); // Unwanted attributes
                    args.content = args.content.replace(/<(p|a|div|span|strike|strong|i|u)[^>]*?>(\s|&nbsp;|<br\/>|\r|\n)*?<\/(p|a|div|span|strike|strong|i|u)>/gi, ''); // Empty tags
                },
                skin : "boilerplate",
                @if(config('boilerplate.app.locale') !== 'en')
                language: '{{ config('boilerplate.app.locale') }}'
                @endif
            };
        </script>
    @endpush
    @php(define('LOAD_TINYMCE', true))
@endif
