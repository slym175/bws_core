let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'core/packages/' + directory;
const dist = 'public/vendor/bws/' + directory;

mix
    .sass(source + '/resources/assets/sass/shortcode.scss', dist + '/css')
    .js(source + '/resources/assets/js/shortcode.js', dist + '/js')
    .copyDirectory(dist + '/js', source + '/resources/dist/js')
    .copyDirectory(dist + '/css', source + '/resources/dist/css')
