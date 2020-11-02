@extends('layouts.app')

@section('content')

@include('include._messages')

<div class="container">
	<div class="row">
		<div class="d-block d-lg-none col-12">
			@include('include.user._userInfo',['user'=>$user,'subscribed'=>0])
			<br>
			@include('user.include._userGroups',['userGroups'=>$userGroups])
			<br>
		</div>
		
		<div class="col-12 col-lg-9">
			<div class="card">
				<div class="card-header">{{ __('user.My profile') }}</div>
				<div class="card-body">
					<form action="{{ route('user.profileSave',[app()->getLocale()]) }}" method="POST">
						@csrf
						<div class="form-group">
							<label for="password">{{ __('user.Change password') }}</label>
							<input name="password" id="password" type="password" class="form-control">
						</div>
						<div class="form-group">
							<label for="password2">{{ __('user.Retype paassword') }}</label>
							<input name="password2" id="password2" type="password" class="form-control">
						</div>
						<div class="form-group">
							<input type="submit" value="{{ __('user.Save') }}" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="d-none d-lg-block col-3">
			@include('include.user._userInfo',['user'=>$user,'subscribed'=>0])
			<br>
			@include('user.include._userGroups',['userGroups'=>$userGroups])
		</div>
	</div>
</div>

@include('user.include._newAvatar')

<script>
	$('#userAvatarModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var commentId = button.data('commentid')
		var modal = $(this)
		modal.find('#answer-id').val(commentId)
	})
</script>


@include('user.include._newGroupModal')

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

<script>
	$('#userGroupMake').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var modal = $(this)
	})
</script>

@endsection