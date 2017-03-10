<div id="comment{{ $comment->id }}">
    <a href="javascript:void(0);">
        <img src="{{ asset($comment->user->avatar) }}" width="30px" height="30px" style="border-radius:50%">
        {{ $comment->user->name }}
    </a>
    @if($instance instanceof \App\Models\Garage)
        <div>
            @for($i = 0; $i < $instance->getRatingBySpecificUser($comment->user->id)['score']; $i ++)
                <i class="fa fa-star" style="font-size:10px;color:#eca33d"></i>
            @endfor
        </div>
    @endif
    <div style="margin-top: 10px">
        <p id="showCommentContent{{ $comment->id }}">{{ $comment->content }}</p>
    </div>
    <div id="editCommentField{{ $comment->id }}" class="hidden">
        <textarea id="commentContent{{ $comment->id }}" placeholder="Your comment..." style="resize:vertical;">{{ $comment->content }}</textarea>
        <p class="editCmtHelp" style="font-size: 75%;">esc: cancel. enter: update.</p>
    </div>
    <div align="left">
        @can('update', $comment)
            <a class="editCommentBtn" commentId="{{ $comment->id }}" href="javascript:void(0);" style="font-size: 70%">Edit</a>
        @endcan
        @can('delete', $comment)
            <a class="deleteCommentBtn" commentId="{{ $comment->id }}" href="javascript:void(0);" style="font-size: 70%">Delete</a>
        @endcan
    </div>

    <br/>
</div>
