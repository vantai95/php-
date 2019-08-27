let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Common
mix.copyDirectory('resources/assets/common/img', 'public/common-assets/img')
    .copyDirectory('resources/assets/common/js', 'public/common-assets/js')
    .copyDirectory('resources/assets/images','public/images');

// Admin
mix.js('resources/assets/admin/js/app.js', 'public/admin-assets/js')
    .babel([
        'resources/assets/admin/js/vendors/bootstrap-datepicker.js',
        'resources/assets/admin/js/vendors/bootstrap-datepicker.ja.js',
        'resources/assets/admin/js/vendors/bootstrap-datepicker.vi.js',
        'resources/assets/admin/js/common.js',
        'resources/assets/admin/js/dashboard.js'
    ], 'public/admin-assets/js/admin.js')
    .copyDirectory('resources/assets/admin/js/pages', 'public/admin-assets/js/pages')
    .sass('resources/assets/admin/sass/app.scss', 'public/admin-assets/css')
    .copyDirectory('resources/assets/admin/img', 'public/admin-assets/img')
    .copy('resources/assets/admin/css/summernote/summernote-ext-faicon.css', 'public/admin-assets/css/summernote')
    .copy('resources/assets/admin/js/summernote/summernote-ext-faicon.js', 'public/admin-assets/js/summernote');

// B2C
mix.js('resources/assets/b2c/js/app.js', 'public/b2c-assets/js')
    .babel([
        'resources/assets/b2c/js/vendors/bootstrap-datepicker.js',
        'resources/assets/b2c/js/vendors/bootstrap-datepicker.ja.js',
        'resources/assets/b2c/js/vendors/bootstrap-datepicker.vi.js',
        'resources/assets/b2c/js/vendors/bootstrap-timepicker.min.js',
        'resources/assets/b2c/js/vendors/unitegallery.min.js',
        'resources/assets/b2c/js/vendors/ug-theme-tiles.js',
    ], 'public/b2c-assets/js/vendor.js')
    .styles([
        'resources/assets/b2c/css/vendors/bootstrap-datepicker.css',
        'resources/assets/b2c/css/vendors/bootstrap-timepicker.min.css',
        'resources/assets/b2c/css/vendors/unite-gallery.css',
    ],'public/b2c-assets/css/vendor.css')
    .sass('resources/assets/b2c/sass/app.scss', 'public/b2c-assets/css')
    .copyDirectory('resources/assets/b2c/img', 'public/b2c-assets/img')
    .copy('resources/assets/b2c/js/jquery.min.js', 'public/b2c-assets/js');

mix.copy('resources/assets/b2c/icons','public/b2c-assets/images',false);

mix.version();
