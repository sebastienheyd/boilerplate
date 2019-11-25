@if(!defined('LOAD_CODEMIRROR'))
    @push('css')
        <link rel="stylesheet" href="{{ mix('/js/codemirror/codemirror.min.css', '/assets/vendor/boilerplate') }}">
        <style>.CodeMirror {border:1px solid #CCC;height:auto;font-size: 12px}</style>
    @endpush

    @php
        $default = [
            'mode/xml/xml.js',
            'mode/css/css.js',
            'mode/javascript/javascript.js',
            'mode/htmlmixed/htmlmixed.js',
            'addon/edit/matchbrackets.js',
            'addon/edit/matchtags.js',
            'addon/edit/closetag.js',
            'addon/fold/xml-fold.js',
            'addon/selection/active-line.js'
        ];

        if(isset($js) && is_array($js)) {
            $default = array_merge($default, $js);
        }

        $js = array_unique($default);
    @endphp

    @push('js')
        <script src="{{ mix('/js/codemirror/codemirror.min.js', '/assets/vendor/boilerplate') }}"></script>
        <script src="{{ mix('/js/codemirror/jquery.codemirror.min.js', '/assets/vendor/boilerplate') }}"></script>
        @if(!empty($js))
            @foreach($js as $script)
                <script src="{{ asset('/assets/vendor/boilerplate/js/codemirror/'.$script) }}"></script>
            @endforeach
        @endif
    @endpush

    @isset($theme)
        @push('css')
            <link rel="stylesheet" href="/assets/vendor/boilerplate/js/codemirror/theme/{{ $theme }}.css">
        @endpush
        @push('js')
            <script>
                $.fn.codemirror.defaults.theme = '{{ $theme }}';
            </script>
        @endpush
    @endisset

    @php(define('LOAD_CODEMIRROR', true))
@endif
