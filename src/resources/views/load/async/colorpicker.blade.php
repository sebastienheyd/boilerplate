@once
@component('boilerplate::minify')
    <script>
        loadScript('{{ mix('/plugins/spectrum-colorpicker2/spectrum.min.js', '/assets/vendor/boilerplate') }}', () => {
            loadStylesheet('{{ mix('/plugins/spectrum-colorpicker2/spectrum.min.css', '/assets/vendor/boilerplate') }}', () => {
                registerAsset('ColorPicker');
            });
        })
    </script>
@endcomponent
@endonce