export default class Bookmark
{
    constructor(app) {
        this.jQuery = app.jQuery;
        this.window = app.window;
    }

    init() {
        const $ = this.jQuery;
        var self = this;

        $(document).on('click', '.addBookmarkBtn', function (event) {
            var btn = $(event.currentTarget);

            self.create(btn);
        });

        $(document).on('click', '.deleteBookmarkBtn', function (event) {
            var btn = $(event.currentTarget);
            self.destroy(btn);
        });

        $(document).on('click', '#viewBookmarkBtn', function (event) {
            var btn = $(event.currentTarget);
            var viewFieldId = btn.attr('href');

            $.ajax({
                url: laroute.action('App\Http\Controllers\Home\BookmarkController@index'),
                method: 'GET',
                success: function (response) {
                    if (response.status == -1) {
                        var errors = response.data;
                        errors.forEach(function (error) {
                            alert(error.message);
                        });
                    } else {
                        $(viewFieldId).html(response);
                    }
                }
            });
        });

        $('#myWorldField').ready(function () {
            $('#viewBookmarkBtn').click();
        });
    }

    create(btn) {
        const $ = this.jQuery;

        var bookmarkableId = btn.data('instance-id');
        var bookmarkableType = btn.data('bookmarkable-type');

        $.ajax({
            url: laroute.action('App\Http\Controllers\Home\BookmarkController@store'),
            method: 'POST',
            data: {'bookmarkable_type' : bookmarkableType, 'bookmarkable_id' : bookmarkableId},
            success: function (response) {
                if (response.status == -1) {
                    var errors = response.data;
                    errors.forEach(function (error) {
                        alert(error.message);
                    });
                } else {
                    if (btn.data('bookmark-option') === 'bookmarkedFromVisit') {
                        btn.removeClass('addBookmarkBtn');
                        btn.attr('title', 'Bookmarked');
                        btn.html('<i class="fa fa-bookmark" aria-hidden="true" style="color:#eff050; font-size:18px"></i>');
                    } else {
                        var bookmark = response.data;
                        btn.removeClass('addBookmarkBtn').addClass('deleteBookmarkBtn');
                        btn.attr('title', 'Bookmarked');
                        btn.attr('data-bookmark-id', bookmark.id);
                        btn.html('<i class="fa fa-bookmark" aria-hidden="true" style="color:#eff050; font-size:26px"></i>');
                    }
                }
            }
        });
    }

    destroy(btn) {
        const $ = this.jQuery;
        var bookmarkedId = btn.data('bookmark-id');

        $.ajax({
            url: laroute.action('App\Http\Controllers\Home\BookmarkController@destroy', {'bookmark' : bookmarkedId}),
            method: 'POST',
            data: {'_method' : 'DELETE'},
            success: function (response) {
                if (response.status == -1) {
                    var errors = response.data;
                    errors.forEach(function (error) {
                        alert(error.message);
                    });
                } else {
                    if (btn.data('bookmark-option') === 'unbookmark') {
                        var bookmark = response.data;
                        btn.removeClass('deleteBookmarkBtn').addClass('addBookmarkBtn');
                        btn.attr('title', 'Add to bookmark');
                        btn.removeAttr('data-bookmark-id');
                        btn.attr('data-instance-id', bookmark.bookmarkable_id);
                        btn.attr('data-bookmarkable-type', bookmark.bookmarkable_type);
                        btn.html('<i class="fa fa-bookmark-o" aria-hidden="true" style="color:rgba(75, 214, 14, 1); font-size:26px"></i>');
                    }

                    if (btn.data('bookmark-option') === 'deleteBookmark') {
                        btn.closest('div').remove();
                    }

                }
            }
        });
    }
    
}
