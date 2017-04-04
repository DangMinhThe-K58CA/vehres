export default class Search
{
    constructor(app) {
        this.jQuery = app.jQuery;
        this.window = app.window;
    }

    init(displayFields) {
        var self = this;
        const $ = self.jQuery;

        $('.searchBox').ready(function () {
            $('.selectInstancePicker').selectpicker({
                style: 'btn-info',
                size: 4
            });
        });

        window.globalTimeout = null;
        $('.searchInput').on('keyup', function (e) {
            if (globalTimeout != null) {
                clearTimeout(globalTimeout);
            }

            globalTimeout = setTimeout(function() {
                globalTimeout = null;

                var input = $(e.currentTarget);

                if (e.which === 13) {
                    input.blur();
                }
                if (e.which === 27) {
                    input.val('');
                }

                var searchKey = input.val();
                var searchParameter = input.data('search-parameter');
                var option = input.closest('div').find('select.selectInstancePicker').val();
                $.ajax({
                    url: searchParameter.url,
                    method: 'GET',
                    data: {'searchKey' : searchKey, 'option' : option},
                    success: function (response) {
                        var displayField = displayFields[option];
                        $('#' + displayField).html(response);
                    }
                });
            }, 500);

        });
    }
}
