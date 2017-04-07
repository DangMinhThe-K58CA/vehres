export default class PartnerGarage
{
    constructor(app) {
        this.jQuery = app.jQuery;
    }

    init() {
        $('a[name="showGarageBtn"]').click(function(event) {
            var garageId = $(event.currentTarget).data('garage-id');
            $.ajax({
                url: laroute.action('App\Http\Controllers\Partner\GarageController@show', {'garage' : garageId}),
                method: 'GET',
                success: function (response) {
                    $('#showGarageModal').html(response);
                }
            });
        });
    }
}
