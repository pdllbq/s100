<div class="modal-header">
<h5 class="modal-title" id="modal-template-title">{{ __('message.Message') }}</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" id="modal-template-body">

	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<small class="post-info">
					<a href="{{ route('user.show',[app()->getLocale(),$message->from_name]) }}">&commat;{{ $message->from_name }}</a> | 
					{{ $message->created_at->diffForHumans() }}
				</small>
				<br>
				{{ $message->message }}
			</div>
		</div>
	</div>
	
</div>
<div class="modal-footer" id="modal-template-footer">
	<button class="btn btn-success" onClick="Message.create('{{ route('message.create',[app()->getLocale(),'@'.$message->from_name],'@'.$message->from_name) }}')">{{ __('message.Answer') }}</button>
	<button class="btn btn-primary" onclick="Message.index('{{ route('message.index',[app()->getLocale()]) }}')">{{ __('message.Back') }}</button>
	<button class="btn btn-danger" onClick="Message.delete('{{ route('message.delete',[app()->getLocale(),$message->id]) }}','{{ route('message.index',[app()->getLocale()]) }}')">{{ __('message.Delete') }}</button>
</div>