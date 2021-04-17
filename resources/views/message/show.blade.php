<div class="modal-header">
<h5 class="modal-title" id="modal-template-title">{{ $userName }}</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>

</div>
<div class="modal-body" id="modal-template-body">

	@foreach($messages as $message)
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					@if($message->from_name==\Auth::user()->name)
					<div class="chat-message-my">
					@else
					<div class="chat-message-friend">
					@endif
						<small class="post-info">
							@if($message->from_name==\Auth::user()->name) 
								<span class="text-white">{{ $message->created_at->diffForHumans() }}<span>
							@else
								<a href="{{ route('user.show',[app()->getLocale(),$message->from_name]) }}">&commat;{{ $message->from_name }}</a> | 
								{{ $message->created_at->diffForHumans() }}
							@endif
						</small>
						<br>
						{{ $message->message }}
					</div>
				</div>
			</div>
		</div>
	@endforeach
	<div id="chat-end"></div>
	
</div>
<div class="modal-footer" id="modal-template-footer">
	<button class="btn btn-success" onClick="Message.create('{{ route('message.create',[app()->getLocale(),'@'.$userName],'@'.$userName) }}')">{{ __('message.Answer') }}</button>
	<button class="btn btn-primary" onclick="Message.index('{{ route('message.index',[app()->getLocale()]) }}')">{{ __('message.Back') }}</button>
	<button class="btn btn-danger" onClick="Message.delete('{{ route('message.delete',[app()->getLocale(),$userName]) }}','{{ route('message.index',[app()->getLocale()]) }}')">{{ __('message.Delete') }}</button>
</div>
	
<script>
	$('#modal-template .modal-body').scrollTop({{ $messages->count() }}*1000000);
</script>