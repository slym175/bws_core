let mix = require('laravel-mix');
let glob = require('glob');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = directory;
const dist = 'public/vendor/bws/' + directory;

mix
    .postCss(source + '/resources/assets/css/core.css', dist + '/css')
    .postCss(source + '/resources/assets/css/style.bundle.css', dist + '/css')
    .js(source + '/resources/assets/js/scripts.bundle.js', dist + '/js')
    .js(source + '/resources/assets/js/widgets.bundle.js', dist + '/js')
    .js(source + '/resources/assets/js/core.js', dist + '/js')

    .copyDirectory(source + '/resources/assets/plugins', dist + '/plugins')
    .copyDirectory(source + '/resources/assets/media', dist + '/media')

    .copyDirectory(dist + '/plugins', source + '/resources/dist/plugins')
    .copyDirectory(dist + '/media', source + '/resources/dist/media')
    .copyDirectory(dist + '/css', source + '/resources/dist/css')
    .copyDirectory(dist + '/js', source + '/resources/dist/js');

glob.sync('./packages/**/webpack.mix.js').forEach(item => require(item));
