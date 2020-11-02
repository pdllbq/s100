<div class="col-12 comment-answer">
	@foreach($comments as $comment)
	<div class="card">
		<div class="card-body">
			<a id="comment-{{ $comment->id }}" name="comment-{{ $comment->id }}"></a>
			<small class="post-info"><a href="{{route('user.show',[app()->getLocale(),$comment->user->name]) }}">&commat;{{ $comment->user->name }}</a> | {{ $comment->created_at->diffForHumans() }} <br></small>
			{{ $comment->text }}
			@auth
				<div><small class="post-info"><span id="commentModal" class="btn-link" style="cursor:pointer;" data-toggle="modal" data-target="#commentAnswerModal" data-commentid="{{ $comment->id }}">{{ __('post.Make answer') }}</span></small></div>
			@endauth
			<div id="commentData{{ $comment->id }}"></div>
			<script>
				$(function(){
					Comments.getAnswers('{{ route('post.getAnswers',[app()->getLocale(),$comment->id]) }}','commentData{{ $comment->id }}')
				});
			</script>
		</div>
	</div>
	<br>
	@endforeach
</div>
