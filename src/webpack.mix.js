const mix = require('laravel-mix');
const clean = require('clean-webpack-plugin');

mix.webpackConfig({plugins: [new clean(['public'], {verbose: false})]})
    .setPublicPath("public")
    .setResourceRoot('/assets/vendor/boilerplate');

// ============== Main ==============

mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
    'node_modules/admin-lte/dist/js/adminlte.min.js',
    'node_modules/bootbox/bootbox.min.js',
    'resources/assets/js/vendor/bootbox/bootbox.locales.js',
    'node_modules/bootstrap-notify/bootstrap-notify.min.js',
    'resources/assets/js/boilerplate.js'
], 'public/boilerplate.min.js').version();

mix.sass('resources/assets/scss/boilerplate.scss', 'public/boilerplate.min.css').version();

mix.copy('resources/images/default-user.png', 'public/images/default-user.png', false);

// ============== Moment ==============

mix.scripts([
    'node_modules/moment/min/moment-with-locales.min.js'
], 'public/js/moment/moment-with-locales.min.js').version();

// ============== Datatables ==============

mix.scripts([
    'node_modules/datatables.net/js/jquery.dataTables.min.js',
    'node_modules/datatables.net-bs/js/dataTables.bootstrap.js',
    'node_modules/drmonty-datatables-plugins/sorting/datetime-moment.js'
], 'public/js/datatables/datatables.min.js').version();

mix.copy('node_modules/drmonty-datatables-plugins/i18n', 'public/js/datatables/i18n/', false);

mix.styles(
    'node_modules/datatables.net-bs/css/dataTables.bootstrap.css',
    'public/js/datatables/datatables.min.css'
).version();

// ============== Select2 ==============

mix.scripts([
    'node_modules/select2/dist/js/select2.full.min.js'
], 'public/js/select2/select2.full.min.js').version();

mix.copy('node_modules/select2/dist/js/i18n', 'public/js/select2/i18n/', false);

// ============== iCheck ==============

mix.scripts([
    'node_modules/icheck/icheck.min.js'
], 'public/js/icheck/icheck.min.js').version();

mix.sass('resources/assets/scss/icheck.scss', 'public/js/icheck/icheck.min.css').version();

// ============== DatePicker ==============

mix.styles([
    'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css',
    'node_modules/bootstrap-daterangepicker/daterangepicker.css',
    'node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css',
    'resources/assets/scss/daterangepicker.css'
], 'public/js/datepicker/bootstrap-datepicker3.min.css').version();

mix.scripts([
    'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    'node_modules/bootstrap-daterangepicker/daterangepicker.js',
    'node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
], 'public/js/datepicker/bootstrap-datepicker.min.js').version();

mix.copy('node_modules/bootstrap-datepicker/dist/locales', 'public/js/datepicker/locales', false);

// ============== FileInput ==============

mix.sass(
    'node_modules/bootstrap-fileinput/scss/fileinput.scss',
    'public/js/fileinput/bootstrap-fileinput.min.css'
).version();

mix.scripts([
    'node_modules/bootstrap-fileinput/js/fileinput.min.js',
], 'public/js/fileinput/bootstrap-fileinput.min.js').version();

mix.copy('node_modules/bootstrap-fileinput/js/locales', 'public/js/fileinput/locales', false);

// ======= Code Mirror
mix.scripts(['node_modules/codemirror/lib/codemirror.js'], 'public/js/codemirror/codemirror.min.js').version();
mix.scripts(['resources/assets/js/vendor/codemirror/jquery.codemirror.js'], 'public/js/codemirror/jquery.codemirror.min.js').version();

mix.copy('node_modules/codemirror/addon', 'public/js/codemirror/addon');
mix.copy('node_modules/codemirror/mode', 'public/js/codemirror/mode');
mix.copy('node_modules/codemirror/theme', 'public/js/codemirror/theme');

mix.sass('resources/assets/js/vendor/codemirror/theme/storm.scss', 'public/js/codemirror/theme/storm.css');

mix.styles('node_modules/codemirror/lib/codemirror.css', 'public/js/codemirror/codemirror.min.css').version();

// ============== TinyMCE ==============

mix.copy('node_modules/tinymce/plugins', 'public/js/tinymce/plugins');
mix.scripts('resources/assets/js/vendor/tinymce/plugins/codemirror/plugin.js', 'public/js/tinymce/plugins/codemirror/plugin.min.js');
mix.copy('resources/assets/js/vendor/tinymce/plugins', 'public/js/tinymce/plugins');
mix.copy('node_modules/tinymce/skins', 'public/js/tinymce/skins');
mix.copy('node_modules/tinymce/themes', 'public/js/tinymce/themes');

// https://www.tiny.cloud/get-tiny/language-packages/
mix.copy('resources/assets/js/vendor/tinymce/langs', 'public/js/tinymce/langs');

mix.scripts([
    'node_modules/tinymce/tinymce.min.js',
    'node_modules/tinymce/jquery.tinymce.min.js'
], 'public/js/tinymce/tinymce.min.js').version();
