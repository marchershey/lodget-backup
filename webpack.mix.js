const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [require("tailwindcss")])
    .browserSync({
        proxy: "10.0.0.17",
        open: false,
        notify: false,
    });
//     .webpackConfig({
//         devServer: {
//             proxy: {
//                 "*": "http://localhost:3000",
//             },
//         },
//     });

// // This sets your HMR host and port to the device running `php artisan serve`
mix.options({
    hmrOptions: {
        host: "10.0.0.17", // set this to the local ip address (192.168.0.**) of whatever device is running `php artisan serve`
        port: 80, // set this to which port `php artisan serve` is using.
    },
});
