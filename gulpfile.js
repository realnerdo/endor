const elixir = require('laravel-elixir');
require('laravel-elixir-livereload');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass([
        'app.sass',
        './node_modules/normalize.css/normalize.css',
        './node_modules/typicons.font/src/font/typicons.css',
        './node_modules/select2/dist/css/select2.min.css',
        './node_modules/@fengyuanchen/datepicker/dist/datepicker.min.css'
    ], 'public/css/app.css');

    mix.sass([
        'print.sass',
        './node_modules/normalize.css/normalize.css'
    ], 'public/css/print.css');

    mix.scripts([
        './node_modules/jquery/dist/jquery.min.js',
        './node_modules/select2/dist/js/select2.min.js',
        './node_modules/select2/dist/js/i18n/es.js',
        './node_modules/autosize/dist/autosize.min.js',
        './node_modules/@fengyuanchen/datepicker/dist/datepicker.min.js',
        './node_modules/@fengyuanchen/datepicker/i18n/datepicker.es-ES.js',
        './node_modules/chart.js/dist/Chart.min.js',
        'app.js'
    ], 'public/js/app.js');

    mix.livereload();
});
