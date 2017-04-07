import PartnerMaps from './partners/garage/PartnerMaps';

class App
{
    constructor(window) {
        this.window = window;
        this.jQuery = window.jQuery;
    }

    run() {
        this.setup();
        var self = this;

        window.assetUrl = $('#partnerGarageMaps').data('asset-url').slice(0, -1);
        window.partnerMaps = new PartnerMaps(self);
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
