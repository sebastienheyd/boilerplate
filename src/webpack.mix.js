const mix = require('laravel-mix');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
mix.webpackConfig({plugins: [new CleanWebpackPlugin()]})
    .setPublicPath("public")
    .setResourceRoot('/assets/vendor/boilerplate');

// ============== AdminLTE & default ==============

mix.js('resources/assets/js/bootstrap.js', 'public/bootstrap.min.js').version();
mix.js('resources/assets/js/admin-lte.js', 'public/admin-lte.min.js').version();
mix.js('resources/assets/js/boilerplate.js', 'public/boilerplate.min.js').version();

mix.sass('resources/assets/scss/adminlte.scss', 'public/adminlte.min.css').version();

mix.js('resources/assets/js/avatar.js', 'public/avatar.min.js').version();
mix.copy('resources/images/default-user.png', 'public/images/default-user.png', false);

// ============== Moment ==============

mix.scripts([
    'node_modules/moment/min/moment-with-locales.min.js',
], 'public/js/moment/moment-with-locales.min.js').version();

// ============== Datatables ==============

mix.scripts([
    'node_modules/datatables.net/js/jquery.dataTables.min.js',
    'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js',
    'node_modules/drmonty-datatables-plugins/dataRender/datetime.js',
    'node_modules/drmonty-datatables-plugins/sorting/datetime-moment.js',
    'resources/assets/js/datatables.js',
], 'public/js/datatables/datatables.min.js').version();

mix.copy('node_modules/drmonty-datatables-plugins/i18n', 'public/js/datatables/i18n/', false);

mix.styles(
    'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css',
    'public/js/datatables/datatables.min.css'
).version();

// ============== Select2 ==============

mix.scripts([
    'node_modules/select2/dist/js/select2.full.min.js'
], 'public/js/select2/select2.full.min.js').version();

mix.copy('node_modules/select2/dist/js/i18n', 'public/js/select2/i18n/', false);


// ============== DatePicker ==============

mix.sass('resources/assets/scss/daterangepicker.scss', 'public/js/datepicker/datepicker.min.css').version();

mix.scripts([
    'node_modules/admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js',
    'node_modules/admin-lte/plugins/daterangepicker/daterangepicker.js',
], 'public/js/datepicker/datepicker.min.js').version();

// ============== FileInput ==============

mix.sass(
    'node_modules/bootstrap-fileinput/scss/fileinput.scss',
    'public/js/fileinput/bootstrap-fileinput.min.css'
).version();

mix.scripts([
    'node_modules/bootstrap-fileinput/js/fileinput.min.js',
], 'public/js/fileinput/bootstrap-fileinput.min.js').version();

mix.copy('node_modules/bootstrap-fileinput/js/locales', 'public/js/fileinput/locales', false);
mix.copy('node_modules/bootstrap-fileinput/themes', 'public/js/fileinput/themes', false);

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
mix.scripts('resources/assets/js/vendor/tinymce/plugins/customalign/plugin.js', 'public/js/tinymce/plugins/customalign/plugin.min.js');
mix.copy('resources/assets/js/vendor/tinymce/plugins', 'public/js/tinymce/plugins');
mix.copy('node_modules/tinymce/icons', 'public/js/tinymce/icons');
mix.copy('node_modules/tinymce/skins', 'public/js/tinymce/skins');
mix.copy('node_modules/tinymce/themes', 'public/js/tinymce/themes');
mix.copy('node_modules/stickytoolbar/dist', 'public/js/tinymce/plugins');

// Boilerplate skin
mix.copy('resources/assets/js/vendor/tinymce/skins/boilerplate/fonts', 'public/js/tinymce/skins/ui/boilerplate/fonts');
mix.sass('resources/assets/js/vendor/tinymce/skins/boilerplate/content.inline.scss', 'public/js/tinymce/skins/ui/boilerplate/content.inline.min.css');
mix.sass('resources/assets/js/vendor/tinymce/skins/boilerplate/content.mobile.scss', 'public/js/tinymce/skins/ui/boilerplate/content.mobile.min.css');
mix.sass('resources/assets/js/vendor/tinymce/skins/boilerplate/content.scss', 'public/js/tinymce/skins/ui/boilerplate/content.min.css');
mix.sass('resources/assets/js/vendor/tinymce/skins/boilerplate/skin.scss', 'public/js/tinymce/skins/ui/boilerplate/skin.min.css');
mix.sass('resources/assets/js/vendor/tinymce/skins/boilerplate/skin.mobile.scss', 'public/js/tinymce/skins/ui/boilerplate/skin.mobile.min.css');

// https://www.tiny.cloud/get-tiny/language-packages/
mix.copy('resources/assets/js/vendor/tinymce/langs', 'public/js/tinymce/langs');

mix.scripts([
    'node_modules/tinymce/tinymce.min.js',
    'node_modules/tinymce/jquery.tinymce.min.js'
], 'public/js/tinymce/tinymce.min.js').version();

// ============== FullCalendar ==============

mix.copy('node_modules/fullcalendar/main.min.css', 'public/js/fullcalendar/main.min.css').version();
mix.copy('node_modules/fullcalendar/main.min.js', 'public/js/fullcalendar/main.min.js').version();
mix.copy('node_modules/fullcalendar/locales/*', 'public/js/fullcalendar/locales').version();
mix.js('resources/assets/js/vendor/fullcalendar/jquery.fullcalendar.js', 'public/js/fullcalendar/jquery.fullcalendar.min.js').version();
