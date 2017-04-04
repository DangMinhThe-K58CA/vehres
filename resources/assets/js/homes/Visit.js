import Search from './Search';

export default class Visit
{
    constructor(app) {
        this.jQuery = app.jQuery;
        this.window = app.window;
    }

    init() {
        const $ = this.jQuery;
        var self = this;

        $(document).on('click', '.deleteVisitBtn', function (event) {
            var btn = $(event.currentTarget);
            self.destroy(btn);
        });

        $(document).on('click', '#viewVisitBtn', function (event) {
            var btn = $(event.currentTarget);
            var viewFieldId = btn.attr('href');

            $.ajax({
                url: laroute.action('App\Http\Controllers\Home\VisitController@index'),
                method: 'GET',
                success: function (response) {
                    if (response.status == -1) {
                        var errors = response.data;
                        errors.forEach(function (error) {
                            alert(error.message);
                        });
                    } else {
                        $(viewFieldId).html(response);

                        var searchBox = new Search(self);
                        var displayFields = [];
                        displayFields['App\\Models\\Article'] = 'visitedArticles';
                        displayFields[ 'App\\Models\\Garage'] = 'visitedGarages';
                        searchBox.init(displayFields);
                    }
                }
            });
        });
    }

    destroy(btn) {
        const $ = this.jQuery;
        var visitId = btn.data('visit-id');

        $.ajax({
            url: laroute.action('App\Http\Controllers\Home\VisitController@destroy', {'visit' : visitId}),
            method: 'POST',
            data: {'_method' : 'DELETE'},
            success: function (response) {
                if (response.status == -1) {
                    var errors = response.data;
                    errors.forEach(function (error) {
                        alert(error.message);
                    });
                } else {
                    btn.closest('div').remove();
                }
            }
        });
    }

}
