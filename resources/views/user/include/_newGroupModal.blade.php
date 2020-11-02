<div class="container">
	<div class="col-12">
		<div class="modal fade" id="userGroupMakeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"> {{ __('user.Make group') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				  <div id="errors-place" class="col-12"></div>
				  <form method="POST" action="{{ route('group.make',app()->getLocale()) }}">
					  @csrf
					  <div class="form-group">
						  <label for="name">{{ __('group.Name') }}</label>
						  <input class="form-control" type="text" id="name" name="name">
					  </div>
				  <div class="modal-footer">
					  <button id="addGroup" type="button" class="btn btn-primary" onclick="Group.make('{{ route('group.make',app()->getLocale()) }}')">{{ __('user.Make') }}</button>
				  </div>
				  </form>
			  </div>
			</div>
		  </div>
		</div>
	</div>
</div>