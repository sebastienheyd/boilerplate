@once
@php
    $default = [
        'mode/xml/xml.js',
        'mode/css/css.js',
        'mode/javascript/javascript.js',
        'mode/htmlmixed/htmlmixed.js',
        'addon/edit/matchtags.js',
        'addon/edit/matchbrackets.js',
        'addon/edit/closetag.js',
        'addon/fold/xml-fold.js',
        'addon/selection/active-line.js'
    ];

    if (isset($js) && is_array($js)) {
        $default = array_merge($default, $js);
    }

    $js = array_unique($default);
@endphp
@component('boilerplate::minify')
    <script>
        loadStylesheet('{{ mix('/plugins/codemirror/codemirror.min.css', '/assets/vendor/boilerplate') }}', () => {
            loadStylesheet('/assets/vendor/boilerplate/plugins/codemirror/theme/{{ $theme ?? 'storm' }}.css', () => {
                loadScript('{{ mix('/plugins/codemirror/jquery.codemirror.min.js', '/assets/vendor/boilerplate') }}', () => {
                    @if(!empty($js))
                        @foreach($js as $script)
                            loadScript("/assets/vendor/boilerplate/plugins/codemirror/{{ $script }}", () => {
                            @if ($loop->last)
                                registerAsset('CodeMirror', () => {
                                    $.fn.codemirror.defaults.theme = '{{ $theme ?? 'storm' }}';
                                });
                            @endif
                        @endforeach
                        @foreach($js as $script)
                            });
                        @endforeach
                    @endif
                });
            });
        });
    </script>
@endcomponent
@endonce
