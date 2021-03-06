@foreach($comments as $comment)
<div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
        <strong>{{ $comment->user->name }}</strong>
		<p>{{ $comment->body }}</p>
@if($level <= 3)
        <a href="" id="reply"></a>
        <form method="post" action="{{ route('frontend.ams.comments.store') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="body" class="form-control" />
                <input type="hidden" name="datastore_id" value="{{ $datastore_id }}" />
                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" value="Reply" />
            </div>
		</form>
		@include('phpsa-datastore::frontend.ams.includes.comment', ['comments' => $comment->replies, 'datastore_id' => $datastore->id, 'level' => ++$level])
@endif
	</div>
@endforeach