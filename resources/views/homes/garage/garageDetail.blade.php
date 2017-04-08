<div class="container col-md-12" id="viewGarageDetailFieldResponsed">
    <div class="row">
        <div class="card hovercard">
            <div class="cardheader" align="right">
                <div id="actionBar">
                    <a id="closeDetailBtn" href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true" style="font-size:30px; color: #fbab56"></i></a>
                </div>
            </div>
            <div class="avatar">
                <img alt="" src="{{ asset($garage->avatar) }}">
            </div>
            <div class="info" id="garageInfoField">
                <div class="title">
                    @if ($bookmarked != null)
                        <a class="deleteBookmarkBtn" data-bookmark-option="unbookmark" data-bookmark-id="{{ $bookmarked->id }}" href="javascript:void(0);" data-toggle="tooltip" title="Bookmarked"><i class="fa fa-bookmark" aria-hidden="true" style="color:#eff050; font-size:26px"></i></a>
                    @else
                        <a class="addBookmarkBtn" data-instance-id="{{ $garage->id }}" data-bookmarkable-type="{{ get_class($garage) }}" href="javascript:void(0);" data-toggle="tooltip" title="Add to bookmark"><i class="fa fa-bookmark-o" aria-hidden="true" style="color:rgba(75, 214, 14, 1); font-size:26px"></i></a>
                    @endif
                    <a target="_blank" href="javascript:void(0);">{{ $garage->name }}</a>
                </div>
                <div class="desc">{{ $garage->short_description }}</div>
            </div>
            <div id="showRatingField">
                <div>
                    @php($avgRating = $garage->rating)
                    @for($i = 1; $i <= 10; $i ++)
                        @if($i <= intval($avgRating))
                            <a href="javascript:void(0);" class="ratingStarBtn" data-score="{{ $i }}">
                                <i class="fa fa-star" style="font-size:20px;color:#eca33d"></i>
                            </a>
                            @if($i == intval($avgRating) && $avgRating > intval($avgRating))
                                <a href="javascript:void(0);" class="ratingStarBtn" data-score="{{ ++$i }}">
                                    <i class="fa fa-star-half-full" style="font-size:20px;color:#eca33d"></i>
                                </a>
                            @endif
                        @else
                            <a href="javascript:void(0);" class="ratingStarBtn" data-score="{{ $i }}">
                                <i class="fa fa-star-o" style="font-size:20px;color:#eca33d"></i>
                            </a>
                        @endif
                    @endfor
                </div>
                <a id="showRatingStatisticBtn" href="javascript:void(0);">Total <i class="fa fa-user-o" style="font-size:16px;color:#47e444"></i> {{ $ratingTimes }} </a>
                <div id="ratingStatisticField" class="hidden" align="left">
                    <div>
                        @for($score = sizeof($ratingStatistic) - 1; $score >= 1; $score --)
                            @if($ratingStatistic[$score] != 0)
                                <label>{{ $ratingStatistic[$score] }} <i class="fa fa-user-o" style="font-size:16px;color:#47e444"></i></label>
                                @for($star = 1; $star <= $score; $star ++)
                                    <i class="fa fa-star" style="font-size:10px;color:#eca33d"></i>
                                @endfor
                                <br/>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
            <div id="garageDescriptionField">
                <div class="desc" align="left" id="garageDescriptionInShort">
                    {{ substr($garage->description, 0, 50) . '...' }} <a href="javascript:void(0);" id="showMoreGarageDetailBtn">more.</a>
                </div>
                <div class="desc hidden" align="left" id="garageFullDescription">
                    {{ $garage->description }}
                    <a href="javascript:void(0);" id="hideGarageDetailBtn"> hide.</a>
                </div>
            </div>
            <div align="left">
                <a href="javascript:void(0);"><i class="fa fa-map-marker" style="font-size:24px;color:#181acf"></i> {{ $garage->address }}</a>
                <br/>
                <a href="javascript:void(0);"><i class="fa fa-phone" style="font-size:24px;color:#181acf"></i> {{ $garage->phone_number }}</a>
                <br/>
                <a href="javascript:void(0);"><i class="fa fa-globe" style="font-size:24px;color:#181acf"></i> {{ $garage->website }}</a>
                <br/>
                <a href="javascript:void(0);"><i class="fa fa-clock-o" style="font-size:24px;color:#181acf"></i> {{ $garage->working_time }}</a>
                <hr class="decorated"/>
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
                <hr/>
                <br/>
                <br/>
            </div>
        </div>
    </div>
</div>
