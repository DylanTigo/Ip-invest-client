const mix = require('laravel-mix');
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
 mix.webpackConfig({
    resolve: {
        extensions: [".*",".wasm",".mjs",".js",".jsx",".json",".*"]
        
    }
});

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/metismenu/dist/metisMenu.min.js', 'public/js')
   .copy('node_modules/metismenu/dist/metisMenu.min.css', 'public/css')
   .copy('node_modules/summernote/dist/summernote.min.js', 'public/js')
   .copy('node_modules/summernote/dist/summernote.min.css', 'public/css')
   .copy('node_modules/summernote/dist/font', 'public/font')
   .copy('node_modules/datatables.net/js/jquery.dataTables.js', 'public/js')
   .copy('node_modules/datatables.net-bs5/js/dataTables.bootstrap5.js', 'public/js')
   .copy('node_modules/datatables.net-bs5/css/dataTables.bootstrap5.css', 'public/css')
   mix.js('resources/js/app.js', 'public/js')
   .sourceMaps();