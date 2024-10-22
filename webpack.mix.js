const {mix} = require('laravel-mix');

mix.setPublicPath('')
    .js('js/app.js', 'dist/js')
    .sass('sass/app.scss', 'dist/css')
    .options({
        processCssUrls: false
    });
