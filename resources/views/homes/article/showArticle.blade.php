@extends('layouts.app')
@section('css')
    <link href= {{ asset("/css/homes/article/animate.min.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/bootstrap.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/chocolat.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/component.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/style.css") }} rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
@endsection
@section('content')

    @php($bookmarked = Auth::user()->getSpecificBookmark(get_class($article), $article->id))
    <div class="technology">
        <div class="container">
            <div class="col-md-9 technology-left">
                <div id="articleBound">
                    <div class="agileinfo" id="showArticleField">
                        <input type="hidden" id="articleId" value="{{ $article->id }}">
                        <span>
                            @if ($bookmarked === null)
                                <a class="addBookmarkBtn" data-instance-id="{{ $article->id }}" data-bookmarkable-type="{{ get_class($article) }}" href="javascript:void(0);" data-toggle="tooltip" title="Add to bookmark"><i class="fa fa-bookmark-o" aria-hidden="true" style="color:rgba(75, 214, 14, 1); font-size:18px"></i></a>
                            @else
                                <a class="deleteBookmarkBtn" data-bookmark-option="unbookmark" data-bookmark-id="{{ $bookmarked->id }}" href="javascript:void(0);" data-toggle="tooltip" title="Bookmarked"><i class="fa fa-bookmark" aria-hidden="true" style="color:#eff050; font-size:26px"></i></a>
                            @endif
                                <h2 class="w3">{{ $article->title }}</h2>
                        </span>

                        <div class="single">
                            <img src="{{ asset($article->avatar) }}" class="img-responsive" alt="{{ $article->avatar }}">
                            <div class="b-bottom">
                                <h3 class="top">{{ $article->short_description }}</h3>
                                <p class="sub">{!! $article->content !!}</p>
                                <p style="color: rgba(27, 34, 121, 1)">On {{ $article->updated_at }}</p>
                            </div>
                        </div>

                        <div class="response">
                            <div id="showCommentField">
                                <div>
                                    <input type="hidden" id="commentPaginateNumber" value="{{ config('common.garage.comment.paginate') }}">
                                    <input type="hidden" id="numberOfComment" value="{{ count($comments) }}">
                                    <a href="javascript:void(0);" id="viewCommentBtn" btnStatus="0"><b>Comments: {{ count($comments) }}</b> <i class="fa fa fa-commenting-o" style="font-size:16px;color:#21d7ef"></i></a>
                                </div>
                                <div style="margin: 5px;">
                                    <form id="writeCommentForm" align="right" action="{{ action('Home\CommentController@store') }}">
                                        <div class="form-group">
                                            <textarea id="commentContent" style="resize:vertical;" class="form-control" rows="3" id="garageComment" name="garageComment" placeholder="Leave your comment here..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <a id="commentBtn" class="btn btn-primary">Ok</a>
                                        </div>
                                    </form>
                                </div>
                                <br/>
                                <div id="commentField" class="hidden">

                                </div>
                            </div>
                            <div class="media response-info">
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- technology-right -->
            <div class="col-md-3 technology-right">
                <div class="blo-top1" align="center">
                    <div class="tech-btm">
                        <h4>Top Rated Garages </h4>
                        @include('homes.components.topRatedGarages', ['topRateGarages' => $topRateGarages])
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">

            </div>
        </div>
    </div>

    <div class="copyright wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
        <div class="container">
            <p>© 2017 Vehicle Rescuer powered by <a href="javascript:void(0);">VehRes Team</a></p>
        </div>
    </div>
@endsection
