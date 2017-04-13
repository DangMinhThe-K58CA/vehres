const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('app.scss')
        // .webpack('app.js')
        .webpack('partnerApp.js')
        .scripts('layoutPartner.js')
        .sass('homes/welcome.scss', 'public/css/homes/');
    // mix.copy('resources/assets/bowers/wow/dist/wow.min.js', 'public/bowers/wow/wow.min.js');
    // mix.copy('resources/assets/plugins/templateEditor', 'public/templateEditor');

    //    .sass('style.scss')
    //    .scripts('layoutAdmin.js');
    // mix.scripts('helpers/*.js', 'public/js/helpers/helpers.js');
    // mix.copy('resources/assets/bowers/font-awesome/css/font-awesome.min.css', 'public/bowers/font-awesome/css/font-awesome.min.css');
    // mix.copy('resources/assets/bowers/font-awesome/fonts/', 'public/bowers/font-awesome/fonts/');
    // mix.copy('resources/assets/bowers/jquery/dist/jquery.min.js', 'public/bowers/jquery/dist/jquery.min.js')
    //    .copy('resources/assets/bowers/bootstrap/dist/css/bootstrap.min.css', 'public/bowers/bootstrap/dist/css/bootstrap.min.css')
    //     .sass('homes/index.scss', 'public/css/homes/index.css');
    // mix.scripts('helpers/*.js', 'public/js/helpers/helpers.js');
    // mix.copy('resources/assets/bowers/font-awesome/css/font-awesome.min.css', 'public/bowers/font-awesome/css/font-awesome.min.css');
    // mix.copy('resources/assets/bowers/font-awesome/fonts/', 'public/bowers/font-awesome/fonts/');
    //    .sass('style.scss')
    //    .scripts('layoutAdmin.js');
    // mix.scripts('helpers/*.js', 'public/js/helpers/helpers.js');
    // mix.copy('resources/assets/bowers/font-awesome/css/font-awesome.min.css', 'public/bowers/font-awesome/css/font-awesome.min.css');
    // mix.copy('resources/assets/bowers/font-awesome/fonts/', 'public/bowers/font-awesome/fonts/');
    // mix.copy('resources/assets/bowers/jquery/dist/jquery.min.js', 'public/bowers/jquery/dist/jquery.min.js')
    //    .copy('resources/assets/bowers/bootstrap/', 'public/bowers/bootstrap/')
    //    .sass('style.scss')
    //    .scripts('layoutAdmin.js');
    // mix.scripts('helpers/*.js', 'public/js/helpers/helpers.js');
    // mix.copy('resources/assets/bowers/font-awesome/css/font-awesome.min.css', 'public/bowers/font-awesome/css/font-awesome.min.css');
    // mix.copy('resources/assets/bowers/font-awesome/fonts/', 'public/bowers/font-awesome/fonts/');
    // mix.copy('resources/assets/bowers/jquery/dist/jquery.min.js', 'public/bowers/jquery/dist/jquery.min.js')
    //    .copy('resources/assets/bowers/bootstrap/dist/css/bootstrap.min.css', 'public/bowers/bootstrap/dist/css/bootstrap.min.css')
    //     .sass('homes/index.scss', 'public/css/homes/index.css')
    mix.sass('partners/style.scss', 'public/css/partners/style.css');
        // mix.sass('homes/myWorld.scss', 'public/css/homes/myWorld.css');
    mix.copy('resources/assets/sass/homes/article', 'public/css/homes/article');
    // mix.copy('resources/assets/sass/homes/fonts', 'public/css/homes/fonts');
    // mix.scripts('helpers/*.js', 'public/js/helpers/helpers.js');
    // mix.copy('resources/assets/bowers/font-awesome/css/font-awesome.min.css', 'public/bowers/font-awesome/css/font-awesome.min.css');
    // mix.copy('resources/assets/bowers/font-awesome/fonts/', 'public/bowers/font-awesome/fonts/');
});
