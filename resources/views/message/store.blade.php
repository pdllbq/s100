



<div class="modal-header">
	<h5 class="modal-title">{{ __('message.New message') }}</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	@if($userExists==0)
		<div class="alert alert-danger">{{ __('message.User not found') }}</div>
	@else
		<div class="alert alert-success">{{ __('message.Message was sended') }}</div>
	@endif
</div>
<div class="modal-footer">
	<button class="btn btn-primary" data-dismiss="modal">{{ __('message.Ok') }}</button>
</div>