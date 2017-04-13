@extends('partners.layouts.master')

@section('css')
    <link href= {{ asset("/css/homes/article/animate.min.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/bootstrap.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/chocolat.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/component.css") }} rel="stylesheet">
    <link href= {{ asset("/css/homes/article/style.css") }} rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
@endsection

@section('tag')
    @if ($article->status == config('common.article.status.activated'))
        <a href="{{ action('Partner\ArticleController@index', ['status' => config('common.article.status.activated')]) }}">
            Activated Articles
        </a>
        <i class="fa fa-angle-right"></i>
    @else
        <a href="{{ action('Partner\ArticleController@index', ['status' => config('common.article.status.unactivated')]) }}">
            Unactivated Articles
        </a>
        <i class="fa fa-angle-right"></i>
    @endif
    <label>{{ $article->title }}</label>
@stop
@section('content')
    <div class="technology">
        <div class="container">
            <div class="col-md-10 technology-left">
                <div class="modal-content">
                    <div class="agileinfo">
                        <div class="modal-header">
                            @if($article->status === 0)
                                <a class="close" href="{{ action('Partner\ArticleController@edit', ['id' => $article->id]) }}" title="Edit">
                                    <i class="fa fa-pencil-square-o" style="font-size:24px;color:#332ecb"></i>
                                </a>
                            @endif
                            <div>
                                <h4 class="modal-title" id="showGarageLabel">{{ $article->title }}</h4>
                                @include('layouts.alertMessage')
                            </div>
                            <input type="hidden" id="articleId" value="{{ $article->id }}">
                        </div>
                        <div class="modal-body">
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
                                    </div>
                                    <div style="margin: 5px;">

                                    </div>
                                    <br/>
                                </div>
                                <div class="media response-info">
                                    <div class="clearfix"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">

            </div>
        </div>
    </div>
@endsection
