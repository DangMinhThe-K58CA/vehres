@extends('layouts.app')
@section('css')
    <script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- Custom Theme files -->
    <link href='//fonts.googleapis.com/css?family=Raleway:400,600,700' rel='stylesheet' type='text/css'>
    <link href= {{ asset("/css/homes/article/animate.min.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/bootstrap.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/chocolat.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/component.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/welcome.css") }} rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
@endsection

@section('js')
    <script language="JavaScript" src="{{ asset('bowers/wow/wow.min.js') }}"></script>

    <script>
        new WOW().init();
    </script>
@endsection
@section('content')
    <!-- technology-left -->
    <div class="technology">
        <div class="container">
            <div class="col-md-9 technology-left">
                <div class="tech-no">
                    <!-- technology-top -->

                    <div class="tc-ch wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">

                        <div class="tch-img">
                            <a href="{{ action('Home\ArticleController@getSpecificArticle', ['id' => $allArticles[0]->id]) }}"><img src="{{ asset($allArticles[0]->avatar) }}" class="img-responsive" alt=""></a>
                        </div>

                        <h3>
                            @if(Auth::check())
                                @php($bookmarked = Auth::user()->getSpecificBookmark(get_class($allArticles[0]), $allArticles[0]->id))
                                @if ($bookmarked != null)
                                    <a class="deleteBookmarkBtn" data-bookmark-option="unbookmark" data-bookmark-id="{{ $bookmarked->id }}" href="javascript:void(0);" data-toggle="tooltip" title="Bookmarked"><i class="fa fa-bookmark" aria-hidden="true" style="color:#eff050; font-size:26px"></i></a>
                                @else
                                    <a class="addBookmarkBtn" data-instance-id="{{ $allArticles[0]->id }}" data-bookmarkable-type="{{ get_class($allArticles[0]) }}" href="javascript:void(0);" data-toggle="tooltip" title="Add to bookmark"><i class="fa fa-bookmark-o" aria-hidden="true" style="color:rgba(75, 214, 14, 1); font-size:26px"></i></a>
                                @endif
                            @endif

                            <a href="{{ action('Home\ArticleController@getSpecificArticle', ['id' => $allArticles[0]->id]) }}">{{ $allArticles[0]->title }}</a></h3>
                        <h6>BY <a>{{ $allArticles[0]->user->name }} </a> {{ $allArticles[0]->created_at }}.</h6>
                        <p>{{ $allArticles[0]->short_description }}</p>
                        <div class="bht1">
                            <a href="{{ action('Home\ArticleController@getSpecificArticle', ['id' => $allArticles[0]->id]) }}">Continue Reading</a>
                        </div>
                        <div class="soci">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- technology-top -->
                    @for($i = 1; $i <= 5; $i ++)
                        @if($allArticles[$i] !== null)
                            <div class="wthree">
                                <div class="col-md-6 wthree-left wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                                    <div class="tch-img">
                                        <a href="{{ action('Home\ArticleController@getSpecificArticle', ['id' => $allArticles[$i]->id]) }}">
                                            <img src="{{ asset($allArticles[$i]->avatar) }}" class="img-responsive" alt=""></a>
                                    </div>
                                </div>
                                <div class="col-md-6 wthree-right wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                                    <h3>
                                        @if(Auth::check())
                                            @php($bookmarked = Auth::user()->getSpecificBookmark(get_class($allArticles[0]), $allArticles[0]->id))
                                            @if ($bookmarked != null)
                                                <a class="deleteBookmarkBtn" data-bookmark-option="unbookmark" data-bookmark-id="{{ $bookmarked->id }}" href="javascript:void(0);" data-toggle="tooltip" title="Bookmarked"><i class="fa fa-bookmark" aria-hidden="true" style="color:#eff050; font-size:26px"></i></a>
                                            @else
                                                <a class="addBookmarkBtn" data-instance-id="{{ $allArticles[$i]->id }}" data-bookmarkable-type="{{ get_class($allArticles[$i]) }}" href="javascript:void(0);" data-toggle="tooltip" title="Add to bookmark"><i class="fa fa-bookmark-o" aria-hidden="true" style="color:rgba(75, 214, 14, 1); font-size:26px"></i></a>
                                            @endif
                                        @endif

                                        <a href="{{ action('Home\ArticleController@getSpecificArticle', ['id' => $allArticles[$i]->id]) }}">{{ $allArticles[$i]->title }}</a>
                                    </h3>
                                    <h6>BY <a>{{ $allArticles[$i]->user->name }} </a> {{ $allArticles[$i]->created_at }}.</h6>
                                    <p>{{ $allArticles[$i]->short_description }}</p>
                                    <div class="bht1">
                                        <a href="{{ action('Home\ArticleController@getSpecificArticle', ['id' => $allArticles[$i]->id]) }}">Read More</a>
                                    </div>
                                    <div class="soci">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                    @endfor
                </div>
                <div align="center">
                    {{ $allArticles->appends(Request::capture()->except('page'))->links() }}
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

            <div class="col-md-3 technology-right" style="margin-top: 15px; float: right;">
                <div class="blo-top1" align="center">
                    <div class="tech-btm">
                        @if(isset($recentViewedArticles))
                            <h4>Recent Viewed Articles </h4>
                            @include('homes.components.topVisitedArticle', ['viewedArticles' => $recentViewedArticles])
                        @else
                            <h4>Most Viewed Articles </h4>
                            @include('homes.components.topVisitedArticle', ['viewedArticles' => $mostViewedArticles])
                        @endif
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <!-- technology-right -->
        </div>
    </div>
    <div class="copyright wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
        <div class="container">
            <p>© 2017 Vehicle Rescuer powered by <a href="javascript:void(0);">VehRes Team</a></p>
        </div>
    </div>
@endsection
