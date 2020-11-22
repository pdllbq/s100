<div class="card">
	<div class="card-header text-center">&commat;{{ $user->name }}</div>
	<div class="card-body">
		<div class="avatar">
			@if($user->avatar==null)
				<img src="/img/no-avatar.png" alt="avatar">
			@else
				<a href="{{ $user->avatar }}" target="_blank"><img src="{{ $user->avatar }}" alt="avatar"></a>
			@endif
		</div>
		@auth
			@if($user->id==\Auth::user()->id)
				<div id="avatarModal" class="btn btn-link d-flex justify-content-center" data-toggle="modal" data-target="#userAvatarModal">{{ __('user.Edit avatar') }}</div>
			@endif
		@endauth
		<div>{{ __('user.Rating') }}: {{ $user->rating }}</div>
		<div>{{ __('user.Subscribers') }}: {{ $user->subscribers }}</div>
		<?php
		if($subscribed==0){
			$class='btn-primary';
		}else{
			$class='btn-secondary';
		}
		?>
		@auth
			@if($user->id!=\Auth::user()->id)
				@auth
					<div id="message-button" class="btn btn-primary d-flex justify-content-center" onClick="Message.create('{{ route('message.create',[app()->getLocale(),'@'.$user->name]) }}','@{{ $user->name }}');"><i class="fa fa-envelope" aria-hidden="true"> {{ __('user.Message') }}</i></div>
					<div class="pb-1"></div>
					<div id="subscribe-button" class="btn {{ $class }} d-flex justify-content-center" onclick="Subscribe.user('{{ route('subscribe.user',[app()->getLocale(),$user->id]) }}',this.className);"><i class="fa fa-bell" aria-hidden="true"> {{ __('user.Subscribe') }}</i></div>
				@endauth
			@endif
		@endauth
	</div>
</div>