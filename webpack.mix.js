const mix = require('laravel-mix');
const path = require('path');
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

mix.js('resources/js/main.js', 'public/js')
    .version()
    .sourceMaps()
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.join(__dirname, 'resources/js/')
            }
        },
        module: {
            rules: [
                {
                    test: /\.scss$/,
                    loader: "sass-loader",
                    options: {
                        data: '@import "@/assets/styles/common/vars.scss";'
                    }
                },
            ]
        },
    })
    .vue()
    .sourceMaps()
    .browserSync({
        host: process.env.APP_URL,
        proxy: process.env.APP_URL,
    })
    .sass('resources/js/assets/styles/main.scss', 'public/css')
    .version()
    .sourceMaps();
