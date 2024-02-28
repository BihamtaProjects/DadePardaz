const mix = require('laravel-mix');

require("tailwindcss");

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [require('autoprefixer')],
    })
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery'],
    });
mix.postCss('resources/css/app.css', 'public/css', [
    require('tailwindcss'),
]);
