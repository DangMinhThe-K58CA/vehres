@foreach($visits as $visit)
    @php($instance = $visit->visitable)
    @php($bookmarked = Auth::user()->getSpecificBookmark(get_class($instance), $instance->id))
    <div style="margin: 10px;">
        <span class="col-sm-2">
            <img class="img-circle" src="{{ asset($instance->avatar) }}" width="100%" >
        </span>
        <span class="col-sm-10">
            <a target="_blank" href="{{ action('Home\VisitController@show', ['bookmark' => $visit->id]) }}">
                {{ get_class($instance) === 'App\Models\Garage' ? $instance->name : $instance->title }}
            </a>
            @if ($bookmarked === null)
                <a class="addBookmarkBtn" data-bookmark-option="bookmarkedFromVisit" data-instance-id="{{ $instance->id }}" data-bookmarkable-type="{{ get_class($instance) }}" href="javascript:void(0);" data-toggle="tooltip" title="Add to bookmark"><i class="fa fa-bookmark-o" aria-hidden="true" style="color:rgba(75, 214, 14, 1); font-size:18px"></i></a>
            @endif
            <a class="deleteVisitBtn" data-visit-id="{{ $visit->id }}" href="javascript:void(0);"><i class="fa fa-trash" style="color: rgba(153, 5, 12, 1)"></i></a>
            <p>{{ $instance->short_description }}</p>
        </span>
    </div>
@endforeach
