@if(!defined('LOAD_TINYMCE'))
    @push('js')
        <script src="{!! mix('/js/tinymce/tinymce.min.js', '/assets/vendor/boilerplate') !!}"></script>
        <script>
            tinymce.defaultSettings = {
                plugins: "autoresize fullscreen codemirror link lists table media image imagetools",
                toolbar: "code fullscreen | undo redo | styleselect | bold italic underline | customAlignLeft aligncenter customAlignRight alignjustify | table | bullist numlist outdent indent | link media image",
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
                formats: {
                    alignleftimg: { selector: 'img', 'styles': { 'float' :'left', 'margin' : '0 1em 0 0' } },
                    alignrightimg: { selector: 'img', 'styles': { 'float' :'right', 'margin' : '0 0 0 1em' } }
                },
                setup: function (editor) {
                    editor.ui.registry.addButton('customAlignLeft', {
                        icon: 'align-left',
                        onAction: function () {
                            if(editor.selection.getNode().nodeName == 'IMG') {
                                editor.formatter.apply('alignleftimg')
                            } else {
                                editor.formatter.apply('alignleft')
                            }
                        }
                    });

                    editor.ui.registry.addButton('customAlignRight', {
                        icon: 'align-right',
                        onAction: function () {
                            if(editor.selection.getNode().nodeName == 'IMG') {
                                editor.formatter.apply('alignrightimg')
                            } else {
                                editor.formatter.apply('alignright')
                            }
                        }
                    });
                },
                @if(config('boilerplate.app.locale') !== 'en')
                language: '{{ config('boilerplate.app.locale') }}'
                @endif
            };
        </script>
    @endpush
    @php(define('LOAD_TINYMCE', true))
@endif
