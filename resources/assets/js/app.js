
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
import Profile from './homes/user/Profile';
import HomeMaps from './homes/HomeMaps';

require('./bootstrap');

window.initMaps = function () {
    window.homeMaps = new HomeMaps(this);
    window.homeMaps.init();
}

class App
{
    constructor(window) {
        this.window = window;
        this.jQuery = window.jQuery;
    }

    run() {
        this.setup();

        var profile = new Profile(this);
        profile.init();
    }

    setup() {
        const $ = this.jQuery;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
}

(function (window) {
    const app = new App(window);
    app.run();
})(window);
