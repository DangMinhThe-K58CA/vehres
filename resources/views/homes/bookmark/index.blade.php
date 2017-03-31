<div class="panel">
    @include('homes.components.searchBox')
    <div class="col-md-6" id="viewBookmarkedGarages">
        <label>{{ trans_choice('layout.garages', 2) }}</label>
        <div id="bookmarkedGarages">
            @include('homes.bookmark.bookmarks', ['bookmarks' => $bookmarksList['garage']])
        </div>
    </div>

    <div class="col-md-6" id="viewBookmarkedArticles">
        <label>{{ trans_choice('layout.articles', 2) }}</label>
        <div id="bookmarkedArticles">
            @include('homes.bookmark.bookmarks', ['bookmarks' => $bookmarksList['article']])
        </div>
    </div>
</div>
