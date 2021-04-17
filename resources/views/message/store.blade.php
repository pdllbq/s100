<div class="modal-header">
	<h5 class="modal-title">{{ __('message.New message') }}</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	@if($userExists==0)
		<div class="alert alert-danger">{{ __('message.User not found') }}</div>
	@elseif(!$ban)
		<div class="alert alert-success">{{ __('message.Message was sended') }}</div>
		<script>
			
				Message.show('{{ route('message.show',[app()->getLocale(),$u]) }}');
			
		</script>
	@else
		<div class="alert alert-danger">{{ __('user.You are banned until :time',['time'=>$ban]) }}</div>
	@endif
</div>
<div class="modal-footer">
	<button class="btn btn-primary" data-dismiss="modal">{{ __('message.Ok') }}</button>
</div>