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
					<div class="pb-1"></div>
					@if(\Auth::user()->is_moder==1)
						<div class="dropdown">
							<div class="btn btn-danger d-flex justify-content-center dropdown-toggle" type="button" id="banMenuButton" data-toggle="dropdown">
								@if(!$ban)
									<i class="fa fa-ban" aria-hidden="true"> {{ __('user.Ban') }}</i>
								@else
									<i class="fa fa-ban" aria-hidden="true"> {{ __('user.Banned until :time',['time'=>$ban]) }}</i>
								@endif
							</div>
							@if(!$ban)
								<div class="dropdown-menu" aria-labelledby="banMenuButton">
									<a class="dropdown-item" href="{{ route('user.ban',[app()->getLocale(),$user->name,'day']) }}">{{ __('user.Day') }}</a>
									<a class="dropdown-item" href="{{ route('user.ban',[app()->getLocale(),$user->name,'week']) }}">{{ __('user.Week') }}</a>
									<a class="dropdown-item" href="{{ route('user.ban',[app()->getLocale(),$user->name,'month']) }}">{{ __('user.Month') }}</a>
									<a class="dropdown-item" href="{{ route('user.ban',[app()->getLocale(),$user->name,'year']) }}">{{ __('user.Year') }}</a>
									<a class="dropdown-item" href="{{ route('user.ban',[app()->getLocale(),$user->name,'2038']) }}">01.01.2038</a>
								</div>
							@else
								<div class="dropdown-menu" aria-labelledby="banMenuButton">
									<a class="dropdown-item" href="{{ route('user.unban',[app()->getLocale(),$user->name]) }}">{{ __('user.Unban') }}</a>
								</div>
							@endif
							
							@if(!$banIp && $user->ip)
								<div class="pb-1"></div>
								<div id="banIp-button" class="btn btn-danger d-flex justify-content-center"><a href="{{ route('user.banIp',[app()->getLocale(),$user->ip]) }}" class="text-white"><i class="fa fa-ban" aria-hidden="true">{{ __('user.Ban by ip :ip',['ip'=>$user->ip]) }}</i></a></div>
							@elseif($user->ip)
								<div class="pb-1"></div>
								<div id="banIp-button" class="btn btn-danger d-flex justify-content-center"><a href="{{ route('user.unbanIp',[app()->getLocale(),$user->ip]) }}" class="text-white"><i class="fa fa-ban" aria-hidden="true">{{ __('user.Unban ip :ip',['ip'=>$user->ip]) }}</i></a></div>
							@endif
						</div>
					@endif
				@endauth
			@endif
		@endauth
	</div>
</div>