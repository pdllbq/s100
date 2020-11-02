<div class="container">
	<div class="col-12">
		<div class="modal fade" id="userAvatarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"> {{ __('user.New avatar') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				  <form method="POST" action="{{ route('user.uploadAvatar',app()->getLocale()) }}" enctype="multipart/form-data">
					  @csrf
					  <div class="form-group">
						  <input class="form-control" type="file" id="avatar" name="avatar">
					  </div>
				  <div class="modal-footer">
					  <button type="submit" class="btn btn-primary">{{ __('post.Send') }}</button>
				  </div>
				  </form>
			  </div>
			</div>
		  </div>
		</div>
	</div>
</div>