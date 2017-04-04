import Search from './Search';

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
            self.btn = $(event.currentTarget);

            self.create();
        });

        $(document).on('click', '.deleteBookmarkBtn', function (event) {
            self.btn = $(event.currentTarget);
            var bookmarkedId = self.btn.attr('data-bookmark-id');

            self.destroy(bookmarkedId);
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
                        var searchBox = new Search(self);

                        var displayFields = [];
                        displayFields['App\\Models\\Article'] = 'bookmarkedArticles';
                        displayFields[ 'App\\Models\\Garage'] = 'bookmarkedGarages';
                        searchBox.init(displayFields);
                    }
                }
            });
        });

        $('#myWorldField').ready(function () {
            $('#viewBookmarkBtn').click();
        });
    }

    create() {
        const $ = this.jQuery;
        var self = this;

        var bookmarkableId = self.btn.attr('data-instance-id');
        var bookmarkableType = self.btn.attr('data-bookmarkable-type');

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
                    if (self.btn.attr('data-bookmark-option') === 'bookmarkedFromVisit') {
                        self.btn.removeClass('addBookmarkBtn');
                        self.btn.attr('title', 'Bookmarked');
                        self.btn.html('<i class="fa fa-bookmark" aria-hidden="true" style="color:#eff050; font-size:18px"></i>');
                    } else {
                        var bookmark = response.data;
                        self.btn.removeClass('addBookmarkBtn').addClass('deleteBookmarkBtn');
                        self.btn.attr('title', 'Bookmarked');
                        self.btn.attr('data-bookmark-id', bookmark.id);
                        self.btn.attr('data-bookmark-option', 'unbookmark');
                        self.btn.html('<i class="fa fa-bookmark" aria-hidden="true" style="color:#eff050; font-size:26px"></i>');
                    }
                }
            }
        });
    }

    destroy(bookmarkedId) {
        const $ = this.jQuery;
        var self = this;

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
                    if (self.btn.attr('data-bookmark-option') === 'unbookmark') {
                        var bookmark = response.data;
                        self.btn.removeClass('deleteBookmarkBtn').addClass('addBookmarkBtn');
                        self.btn.attr('title', 'Add to bookmark');
                        self.btn.removeAttr('data-bookmark-id');
                        self.btn.removeAttr('data-bookmark-option');
                        self.btn.attr('data-instance-id', bookmark.bookmarkable_id);
                        self.btn.attr('data-bookmarkable-type', bookmark.bookmarkable_type);
                        self.btn.html('<i class="fa fa-bookmark-o" aria-hidden="true" style="color:rgba(75, 214, 14, 1); font-size:26px"></i>');
                    }

                    if (self.btn.attr('data-bookmark-option') === 'deleteBookmark') {
                        self.btn.closest('div').remove();
                    }

                }
            }
        });
    }
    
}
