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

			@if($messages->count()==0)
			<div class="col-12">
				<div class="alert alert-primary">{{ __('message.No messages') }}</div>
			</div>
			@endif
			
			@foreach($messages as $message)
			
			<div class="col-12">
				<a href="#" onClick="Message.show('{{ route('message.show',[app()->getLocale(),$message->id]) }}')">
					{!! $message->readed==0 ? '<i class="fa fa-envelope" aria-hidden="true"></i> ' : '<i class="fa fa-envelope-open" aria-hidden="true"></i> ' !!}
					&commat;{{ $message->from_name }}
				</a>
				{{ $message->created_at->diffForHumans() }}
			</div>
			
			@endforeach

		</div>
	</div>

</div>
<div class="modal-footer" id="modal-template-footer">
	<button class="btn btn-danger" onClick="Message.delete('{{ route('message.delete',[app()->getLocale(),'*']) }}','{{ route('message.index',[app()->getLocale()]) }}')">{{ __('message.Delete all') }}</button>
</div>
</div>