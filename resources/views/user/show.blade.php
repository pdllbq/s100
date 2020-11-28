@extends('layouts.app')

@section('title',$title)

@section('content')

<div class="container">
	<div class="row">
		<div class="col-12 d-lg-none">
				@include('include.user._userInfo',['user'=>$user,'subscribed'=>$subscribed,'ban'=>$ban])
				<br>
				@include('user.include._userGroups',['userGroups'=>$userGroups])
				<br>
		</div>
					
		<div class="col-12 col-lg-9">
		@include('include.post._showPosts',['posts'=>$posts])
		
				
		</div>
				
		<div class="d-none d-lg-block col-lg-3">
				@include('include.user._userInfo',['user'=>$user,'subscribed'=>$subscribed,'ban'=>$ban,'banIp'=>$banIp])
				<br>
				@include('user.include._userGroups',['userGroups'=>$userGroups])
		</div>
		
	</div>
</div>

@include('user.include._newAvatar')

@include('user.include._newGroupModal')

@include('user.include._editGroupModal')

{{ $posts->links() }}

@endsection