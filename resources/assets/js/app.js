
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
import Profile from './homes/user/Profile';
import HomeMaps from './homes/HomeMaps';
import Bookmark from './homes/Bookmark';
import Visit from './homes/Visit';
import Article from './homes/article/Article';

require('./bootstrap');

window.assetUrl = $('#app').data('asset-url').slice(0, -1);

window.initMaps = function () {
    window.homeMaps = new HomeMaps(this);
    window.homeMaps.init('homeMap', null);
}

window.initGarageOnMaps = function () {
    window.homeMaps = new HomeMaps(this);
    var garage = $('#main').data('garage');
    window.homeMaps.init('viewGarageOnMap', garage);
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

        var bookmark = new Bookmark(this);
        bookmark.init();

        var visit = new Visit(this);
        visit.init();

        $('.myWorldField').ready(function(e){
            $('.search-panel .dropdown-menu').find('a').click(function(e) {
                e.preventDefault();
                var param = $(this).attr("href").replace("#","");
                var concept = $(this).text();
                $('.search-panel span#search_concept').text(concept);
                $('.input-group #search_param').val(param);
            });
        });

        var self = this;
        $('#showArticleField').ready(function () {
            var article = new Article(self);
            article.init();
        });
    }

    setup() {
        const $ = this.jQuery;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
    }
}

(function (window) {
    const app = new App(window);
    app.run();
})(window);
