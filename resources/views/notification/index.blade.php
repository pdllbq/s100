<div class="modal-header">
<h5 class="modal-title" id="modal-template-title">{{ __('notification.Notifications') }}</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" id="modal-template-body">

	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="list-group list-group-flush">
					@foreach($notifications as $data)
					<div class="list-group-item">{{ $data->created_at->diffForHumans() }} <a href="{{ route('post.show',[app()->getLocale(),$data->post_slug]).'#comment-'.$data->comment_id }}">{{ __($data->text) }}</a></div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	
</div>

<div class="modal-footer" id="modal-template-footer">
	<button class="btn btn-success" onclick="Notification.clear('{{ route('notification.clear',[app()->getLocale()]) }}');">{{ __('notification.Clear') }}</button>
</div>