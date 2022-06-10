const mix = require('laravel-mix');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
mix.webpackConfig({plugins: [new CleanWebpackPlugin()],stats:'errors-only'})
    .setPublicPath("public")
    .setResourceRoot('/assets/vendor/boilerplate')
    .version();

// ============== AdminLTE & default ==============
mix.sass('resources/assets/scss/adminlte.scss', 'public/adminlte.min.css');
mix.js('resources/assets/js/bootstrap.js', 'public/bootstrap.min.js');
mix.js('resources/assets/js/admin-lte.js', 'public/admin-lte.min.js');
mix.js('resources/assets/js/boilerplate.js', 'public/boilerplate.min.js');
mix.js('resources/assets/js/avatar.js', 'public/avatar.min.js');
mix.copy('resources/assets/img/favicon.svg', 'public/favicon.svg');

// ============== Log viewer ==============
mix.sass('resources/assets/scss/logviewer.scss', 'public/logviewer.min.css');

// ============== Font Awesome ==============
mix.sass('resources/assets/scss/fontawesome.scss', 'public/plugins/fontawesome/fontawesome.min.css');

// ============== Moment ==============
mix.scripts(['node_modules/moment/min/moment-with-locales.min.js'], 'public/plugins/moment/moment-with-locales.min.js');

// ============== Datatables ==============
mix.scripts([
    'node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js',
    'node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
    'node_modules/drmonty-datatables-plugins/dataRender/datetime.js',
    'node_modules/drmonty-datatables-plugins/sorting/datetime-moment.js',
    'resources/assets/js/datatables.js',
], 'public/plugins/datatables/datatables.min.js');
mix.scripts([
    'node_modules/admin-lte/plugins/datatables-buttons/js/buttons.html5.js',
    'node_modules/admin-lte/plugins/datatables-buttons/js/buttons.colVis.js',
    'node_modules/admin-lte/plugins/datatables-buttons/js/buttons.print.js',
    'node_modules/admin-lte/plugins/jszip/jszip.js',
], 'public/plugins/datatables/buttons.min.js');
mix.copy('node_modules/drmonty-datatables-plugins/i18n/*', 'public/plugins/datatables/i18n/');
mix.sass('resources/assets/scss/datatables.scss', 'public/plugins/datatables/datatables.min.css');
mix.copy([
    'node_modules/admin-lte/plugins/datatables-autofill/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-autofill/js/*.min.js',
    'node_modules/admin-lte/plugins/datatables-buttons/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-buttons/js/*.min.js',
    'node_modules/admin-lte/plugins/datatables-colreorder/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-colreorder/js/*.min.js',
    'node_modules/admin-lte/plugins/datatables-fixedcolumns/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-fixedcolumns/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-fixedheader/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-fixedheader/js/*.min.js',
    'node_modules/admin-lte/plugins/datatables-keytable/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-keytable/js/*.min.js',
    'node_modules/admin-lte/plugins/datatables-responsive/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-responsive/js/*.min.js',
    'node_modules/admin-lte/plugins/datatables-rowgroup/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-rowgroup/js/*.min.js',
    'node_modules/admin-lte/plugins/datatables-rowreorder/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-rowreorder/js/*.min.js',
    'node_modules/admin-lte/plugins/datatables-scroller/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-scroller/js/*.min.js',
    'node_modules/admin-lte/plugins/datatables-searchbuilder/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-searchbuilder/js/*.min.js',
    'node_modules/admin-lte/plugins/datatables-searchpanes/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-searchpanes/js/*.min.js',
    'node_modules/admin-lte/plugins/datatables-select/css/*.min.css',
    'node_modules/admin-lte/plugins/datatables-select/js/*.min.js',
], 'public/plugins/datatables/plugins/');

// ============== Select2 ==============
mix.copy('node_modules/admin-lte/plugins/select2/js/select2.full.min.js', 'public/plugins/select2/select2.full.min.js');
mix.copy('node_modules/admin-lte/plugins/select2/js/i18n/*', 'public/plugins/select2/i18n');
mix.sass('resources/assets/scss/select2.scss', 'public/plugins/select2/select2.min.css');

// ============== DateTimePicker ==============
mix.copy('node_modules/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css', 'public/plugins/datepicker/datetimepicker.min.css')
mix.scripts([
    'node_modules/admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js',
], 'public/plugins/datepicker/datetimepicker.min.js');

// ============== DateRangePicker ==============
mix.sass('resources/assets/scss/daterangepicker.scss', 'public/plugins/datepicker/daterangepicker.min.css');
mix.scripts([
    'node_modules/admin-lte/plugins/daterangepicker/daterangepicker.js',
    'resources/assets/js/daterangepicker.js',
], 'public/plugins/datepicker/daterangepicker.min.js');

// ============== FileInput ==============
mix.sass('node_modules/bootstrap-fileinput/scss/fileinput.scss', 'public/plugins/fileinput/bootstrap-fileinput.min.css');
mix.scripts(['node_modules/bootstrap-fileinput/js/fileinput.min.js'], 'public/plugins/fileinput/bootstrap-fileinput.min.js');
mix.copy('node_modules/bootstrap-fileinput/js/locales', 'public/plugins/fileinput/locales');
mix.copy('node_modules/bootstrap-fileinput/themes', 'public/plugins/fileinput/themes');

// ======= Code Mirror
mix.js('resources/assets/js/vendor/codemirror/jquery.codemirror.js', 'public/plugins/codemirror/jquery.codemirror.min.js');
mix.copy('node_modules/admin-lte/plugins/codemirror/addon', 'public/plugins/codemirror/addon');
mix.copy('node_modules/admin-lte/plugins/codemirror/mode', 'public/plugins/codemirror/mode');
mix.copy('node_modules/admin-lte/plugins/codemirror/theme', 'public/plugins/codemirror/theme');
mix.sass('resources/assets/js/vendor/codemirror/theme/storm.scss', 'public/plugins/codemirror/theme/storm.css');
mix.sass('resources/assets/scss/codemirror.scss', 'public/plugins/codemirror/codemirror.min.css');

// ============== TinyMCE ==============
mix.copy('node_modules/tinymce/plugins', 'public/plugins/tinymce/plugins');
mix.scripts('resources/assets/js/vendor/tinymce/plugins/codemirror/plugin.js', 'public/plugins/tinymce/plugins/codemirror/plugin.min.js');
mix.scripts('resources/assets/js/vendor/tinymce/plugins/customalign/plugin.js', 'public/plugins/tinymce/plugins/customalign/plugin.min.js');
mix.copy('resources/assets/js/vendor/tinymce/plugins', 'public/plugins/tinymce/plugins');
mix.copy('node_modules/tinymce/icons', 'public/plugins/tinymce/icons');
mix.copy('node_modules/tinymce/skins', 'public/plugins/tinymce/skins');
mix.copy('node_modules/tinymce/themes', 'public/plugins/tinymce/themes');

// Boilerplate dark mode
mix.copy('resources/assets/js/vendor/tinymce/skins/boilerplate-dark/skins/content', 'public/plugins/tinymce/skins/content');
mix.copy('resources/assets/js/vendor/tinymce/skins/boilerplate-dark/skins/ui', 'public/plugins/tinymce/skins/ui');

// https://www.tiny.cloud/get-tiny/language-packages/
mix.copy('resources/assets/js/vendor/tinymce/langs', 'public/plugins/tinymce/langs');

mix.scripts([
    'node_modules/tinymce/tinymce.min.js',
    'node_modules/tinymce/jquery.tinymce.min.js'
], 'public/plugins/tinymce/tinymce.min.js');

// ============== FullCalendar ==============
mix.scripts([
    'node_modules/admin-lte/plugins/fullcalendar/main.min.js',
    'resources/assets/js/vendor/fullcalendar/jquery.fullcalendar.js'
], 'public/plugins/fullcalendar/fullcalendar.min.js');
mix.sass('resources/assets/scss/fullcalendar.scss', 'public/plugins/fullcalendar/main.min.css');
mix.copy('node_modules/admin-lte/plugins/fullcalendar/locales/*', 'public/plugins/fullcalendar/locales');

// ============== Spectrum ColorPicker ==============

mix.sass('resources/assets/scss/colorpicker.scss', 'public/plugins/spectrum-colorpicker2/spectrum.min.css');
mix.copy('node_modules/spectrum-colorpicker2/dist/spectrum.min.js', 'public/plugins/spectrum-colorpicker2');

// ============== Pusher ==============

mix.js('resources/assets/js/pusher.js', 'public/pusher.min.js');