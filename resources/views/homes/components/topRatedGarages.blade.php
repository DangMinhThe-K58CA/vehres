@foreach($topRateGarages as $garage)
    <div class="blog-grids wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
        <div>
            <div class="col-md-4 col-md-offset-4">
                <a href="{{ action('Home\GarageController@show', ['id' => $garage->id]) }}">
                    <img src="{{ asset($garage->avatar) }}" class="img-circle img-responsive" alt="">
                </a>
            </div>
            <div class="col-md-2">
                @if(Auth::check())
                    @php($bookmarked = Auth::user()->getSpecificBookmark(get_class($garage), $garage->id))
                    @if ($bookmarked != null)
                        <a class="deleteBookmarkBtn" data-bookmark-option="unbookmark" data-bookmark-id="{{ $bookmarked->id }}" href="javascript:void(0);" data-toggle="tooltip" title="Bookmarked"><i class="fa fa-bookmark" aria-hidden="true" style="color:#eff050; font-size:26px"></i></a>
                    @else
                        <a class="addBookmarkBtn" data-instance-id="{{ $garage->id }}" data-bookmarkable-type="{{ get_class($garage) }}" href="javascript:void(0);" data-toggle="tooltip" title="Add to bookmark"><i class="fa fa-bookmark-o" aria-hidden="true" style="color:rgba(75, 214, 14, 1); font-size:26px"></i></a>
                    @endif
                @endif

            </div>
            <div class="col-md-12">
                <a href="{{ action('Home\GarageController@show', ['id' => $garage->id]) }}">
                    <p>{{ $garage->name }}</p>
                </a>
            </div>
            <div class="col-md-12">
                @php($avgRating = $garage->rating)
                @for($i = 1; $i <= 10; $i ++)
                    @if($i <= intval($avgRating))
                        <i class="fa fa-star" style="font-size:16px;color:#eca33d"></i>
                        @if($i == intval($avgRating) && $avgRating > intval($avgRating))
                            <i class="fa fa-star-half-full" style="font-size:16px;color:#eca33d"></i>
                        @endif
                    @endif
                @endfor
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
@endforeach
