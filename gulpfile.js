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
       .webpack('app.js')
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
        // .sass('homes/myWorld.scss', 'public/css/homes/myWorld.css');
    mix.copy('resources/assets/sass/homes/article', 'public/css/homes/article');
    // mix.copy('resources/assets/sass/homes/fonts', 'public/css/homes/fonts');
    // mix.scripts('helpers/*.js', 'public/js/helpers/helpers.js');
    // mix.copy('resources/assets/bowers/font-awesome/css/font-awesome.min.css', 'public/bowers/font-awesome/css/font-awesome.min.css');
    // mix.copy('resources/assets/bowers/font-awesome/fonts/', 'public/bowers/font-awesome/fonts/');
});
