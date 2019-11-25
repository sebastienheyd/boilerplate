@if(!defined('LOAD_TINYMCE'))
    @push('js')
        <script src="{!! mix('/js/tinymce/tinymce.min.js', '/assets/vendor/boilerplate') !!}"></script>
        <script>
            tinymce.defaultSettings = {
                plugins: 'code autoresize noneditable fullscreen codemirror',
                codemirror: {
                    config: {
                        theme: 'storm'
                    }
                },
                remove_linebreaks : false,
                forced_root_block: false,
                verify_html:false,
                branding: false,
                browser_spellcheck: true,
                encoding: 'UTF-8',
                @if(config('boilerplate.app.locale') !== 'en')
                    language : '{{ config('boilerplate.app.locale') }}'
                @endif
            };
        </script>
    @endpush
    @php(define('LOAD_TINYMCE', true))
@endif
