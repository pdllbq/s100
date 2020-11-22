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


@include('user.include._newGroupModal')

@include('user.include._editGroupModal')

<script>
	$('#userGroupMake').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var modal = $(this)
	})
</script>

@endsection