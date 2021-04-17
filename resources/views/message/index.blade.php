<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="modal-template-title">{{ __('message.Messages') }}</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body" id="modal-template-body">

	<div class="container-fluid">
		<div class="row">

			@if(count($messages)==0)
			<div class="col-12">
				<div class="alert alert-primary">{{ __('message.No messages') }}</div>
			</div>
			@endif
			
			@foreach($messages as $name=>$message)
			
			<div class="col-12 chat-name" onclick="Message.show('{{ route('message.show',[app()->getLocale(),$name]) }}');">
				<div class="chat-name-avatar">
					<div class="chat-name-avatar_inner">
						@if($message['data']->user['avatar']==null)
							<img src="/img/no-avatar.png">
						@else
							<img src="{{ $message['data']->user['avatar'] }}">
						@endif
					</div>
				</div>
				
				<div>
					{{ $message['data']->created_at->diffForHumans() }}
				</div>
				<div>
					<a href="#" onClick="">
						&commat;{{ $name }}
					</a>
				</div>
				@if($message['new']>0)
					<div class="chat-name-new-messages">
						+{{ $message['new'] }}
					</div>
				@endif
			</div>
			
			@endforeach

		</div>
	</div>

</div>
<div class="modal-footer" id="modal-template-footer">
	<button class="btn btn-danger" onClick="Message.delete('{{ route('message.delete',[app()->getLocale(),'*']) }}','{{ route('message.index',[app()->getLocale()]) }}')">{{ __('message.Delete all') }}</button>
</div>
</div>