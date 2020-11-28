
<div class="modal fade" id="commentAnswerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel"> {{ __('post.Answer') }}</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
		@if($ban)
			<div class="container">
					<div class="alert alert-danger">{{ __('user.You are banned until :time',['time'=>$ban]) }}</div>
			</div>
		@else
			<div class="modal-body">
				<form method="POST" action="{{ route('post.addComment',app()->getLocale()) }}">
				@csrf
				<input type="hidden" id="answer-id" name="answer-id" value="">
				<input type="hidden" id="post-slug" name="post-slug" value="">
				<div class="form-group">
					<textarea class="form-control" name="comment" id="comment"></textarea>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('post.Close') }}</button>
				  <button type="submit" class="btn btn-primary">{{ __('post.Send') }}</button>
				</div>
			  </form>
			</div>
		@endif
	</div>
  </div>
</div>