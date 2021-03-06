<div class="modal-header">
	<h5 class="modal-title">{{ __('message.New message') }}</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	@if(!$ban)
		<form method="POST">
			<div class="form-group">
				@csrf
				<label for="user_name">{{ __('message.Whom') }}</label>
				<input id="user_name" type="text" name="user_name" class="form-control" value="{{ $userName }}">
			</div>
			<div class="form-group">
				<label for="message_text">{{ __('message.Message') }}</label>
				<textarea id="message_text" name="message_text" class="form-control" onChange="$('#message_text').val(this.value);"></textarea>
			</div>
		</form>
	@else
		<div class="alert alert-danger">{{ __('user.You are banned until :time',['time'=>$ban]) }}</div>
	@endif
</div>
<div class="modal-footer">
	<button class="btn btn-primary" onClick="Message.store('{{ route('message.store',[app()->getLocale()]) }}');;">{{ __('message.Send') }}</button>
</div>