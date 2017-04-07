@foreach($viewedArticles as $article)
    <div class="blog-grids wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
        <div class="col-md-10 col-md-offset-1">
            <a href="{{ action('Home\ArticleController@getSpecificArticle', ['id' => $article->id]) }}"><img src="{{ asset($article->avatar) }}" class="img-responsive" alt=""></a>
        </div>
        <div class="col-md-1">
            @if(Auth::check())
                @php($bookmarked = Auth::user()->getSpecificBookmark(get_class($article), $article->id))
                @if ($bookmarked != null)
                    <a class="deleteBookmarkBtn" data-bookmark-option="unbookmark" data-bookmark-id="{{ $bookmarked->id }}" href="javascript:void(0);" data-toggle="tooltip" title="Bookmarked"><i class="fa fa-bookmark" aria-hidden="true" style="color:#eff050; font-size:26px"></i></a>
                @else
                    <a class="addBookmarkBtn" data-instance-id="{{ $article->id }}" data-bookmarkable-type="{{ get_class($article) }}" href="javascript:void(0);" data-toggle="tooltip" title="Add to bookmark"><i class="fa fa-bookmark-o" aria-hidden="true" style="color:rgba(75, 214, 14, 1); font-size:26px"></i></a>
                @endif
            @endif

        </div>
        <div class="col-md-12">
            <a href="{{ action('Home\ArticleController@getSpecificArticle', ['id' => $article->id]) }}"><h5>{{ $article->title }}</h5></a>
        </div>
        <div class="clearfix"> </div>
    </div>
@endforeach
