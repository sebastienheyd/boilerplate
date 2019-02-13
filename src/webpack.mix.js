let mix = require('laravel-mix');
const Clean = require('clean-webpack-plugin');

mix.webpackConfig({plugins: [new Clean(['public'], {verbose: false})]})
   .setPublicPath("public")
   .setResourceRoot('/assets/vendor/boilerplate');

// ============== Main ==============

mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
    'node_modules/admin-lte/dist/js/adminlte.min.js',
    'node_modules/bootbox/bootbox.min.js',
    'resources/assets/js/bootbox.locales.js',
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

mix.styles('node_modules/datatables.net-bs/css/dataTables.bootstrap.css',
    'public/js/datatables/datatables.min.css').version();

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
    'node_modules/bootstrap-daterangepicker/daterangepicker.css'
], 'public/js/datepicker/bootstrap-datepicker3.min.css').version();

mix.scripts([
    'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    'node_modules/bootstrap-daterangepicker/daterangepicker.js'
], 'public/js/datepicker/bootstrap-datepicker.min.js').version();

mix.copy('node_modules/bootstrap-datepicker/dist/locales', 'public/js/datepicker/locales', false);

// ============== FileInput ==============

mix.sass(
    'node_modules/bootstrap-fileinput/scss/fileinput.scss',
    'public/js/fileinput/bootstrap-fileinput.min.css').version();

mix.scripts([
    'node_modules/bootstrap-fileinput/js/fileinput.min.js',
], 'public/js/fileinput/bootstrap-fileinput.min.js').version();

mix.copy('node_modules/bootstrap-fileinput/js/locales', 'public/js/fileinput/locales', false);

