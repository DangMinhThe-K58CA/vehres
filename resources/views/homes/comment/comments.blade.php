@foreach($comments as $comment)
    @include('homes.comment.comment', ['comment' => $comment, 'instance' => $instance])
@endforeach
