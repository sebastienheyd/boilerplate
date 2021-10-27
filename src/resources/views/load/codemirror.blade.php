@once
@push('plugin-css')
    <link rel="stylesheet" href="{{ mix('/plugins/codemirror/codemirror.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="stylesheet" href="/assets/vendor/boilerplate/plugins/codemirror/theme/{{ $theme ?? 'storm' }}.css">
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

    if (isset($js) && is_array($js)) {
        $default = array_merge($default, $js);
    }

    $js = array_unique($default);
@endphp
@push('js')
    <script src="{{ mix('/plugins/codemirror/jquery.codemirror.min.js', '/assets/vendor/boilerplate') }}"></script>
@if(!empty($js))
@foreach($js as $script)
    <script src="/assets/vendor/boilerplate/plugins/codemirror/{{ $script }}"></script>
@endforeach
@endif
    <script>registerAsset('CodeMirror',()=>{$.fn.codemirror.defaults.theme='{{ $theme ?? 'storm' }}'});</script>
@endpush
@endonce
