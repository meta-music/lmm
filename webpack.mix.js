const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js').vue();
mix.less('resources/less/app.less', 'public/css');
    // .sass('resources/sass/app.scss', 'public/css');
