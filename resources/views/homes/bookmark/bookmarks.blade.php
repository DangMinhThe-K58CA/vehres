@foreach($bookmarks as $bookmark)
    @php($instance = $bookmark->bookmarkable)
    <div style="margin: 10px;">
        <span class="col-sm-2">
            <img class="img-circle" src="{{ asset($instance->avatar) }}" width="100%" >
        </span>
        <span class="col-sm-10">
            <a target="_blank" href="{{ action('Home\BookmarkController@show', ['bookmark' => $bookmark->id]) }}">
                {{ get_class($instance) === 'App\Models\Garage' ? $instance->name : $instance->title }}
            </a>
            <a class="deleteBookmarkBtn" data-bookmark-option="deleteBookmark" data-bookmark-id="{{ $bookmark->id }}" href="javascript:void(0);"><i class="fa fa-trash" style="color: rgba(153, 5, 12, 1)"></i></a>
            <p>{{ $instance->short_description }}</p>
        </span>
    </div>
@endforeach
