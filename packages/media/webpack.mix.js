let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'core/packages/' + directory;
const dist = 'public/vendor/bws/' + directory;

mix
    .sass(source + '/resources/assets/sass/media.scss', dist + '/css')
    .js(source + '/resources/assets/js/media.js', dist + '/js')
    .js(source + '/resources/assets/js/jquery.addMedia.js', dist + '/js')
    .js(source + '/resources/assets/js/integrate.js', dist + '/js')

    .copyDirectory(dist + '/js', source + '/resources/dist/js')
    .copyDirectory(dist + '/css', source + '/resources/dist/css')
    .copyDirectory(dist + '/images', source + '/resources/dist/images')
    .copyDirectory(dist + '/libraries', source + '/resources/dist/libraries')
