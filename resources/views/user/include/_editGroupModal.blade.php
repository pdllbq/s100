<div class="container">
	<div class="col-12">
		<div class="modal fade" id="userGroupEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"> {{ __('group.Edit group') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				  <div id="edit-errors-place" class="col-12"></div>
				  <form>
					  @csrf
					  <div class="form-group">
						  <label for="groupName">{{ __('group.Name') }}</label>
						  <input class="form-control" type="text" id="groupName" name="groupName">
					  </div>
					  <input type="hidden" id="editId" name="editId">
					  <input type="hidden" id="editSlug" name="editSlug">
					  <input type="hidden" id="editUrl" name="editUrl">
					  <div class="form-group">
						  <label for="description">{{ __('group.Description') }}</label>
						  <textarea name="description" id="description" class="form-control"></textarea>
					  </div>
				  <div class="modal-footer">
					  <button id="addGroup" type="button" class="btn btn-primary" onclick="Group.store()">{{ __('group.Save') }}</button>
				  </div>
				  </form>
			  </div>
			</div>
		  </div>
		</div>
	</div>
</div>