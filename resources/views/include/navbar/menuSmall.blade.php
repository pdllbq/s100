@guest
	<div class="d-none d-md-block">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="{{ route('login', app()->getLocale()) }}">{{ __('auth.Login') }}</a>
			</li>
			@if (Route::has('register'))
				<li class="nav-item">
					<a class="nav-link" href="{{ route('register', app()->getLocale()) }}">{{ __('auth.Register') }}</a>
				</li>
			@endif
		</ul>
	</div>

	<div class="d-block d-md-none">
		<a href="#" class="nav-link dropdown-toggle" type="button" id="dropdownMenuButton"  data-display="absolute" aria-haspopup="true" id="navbarLoginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			{{ __('auth.Login') }}
		</a>
		<div class="dropdown">
			<div class="position-absolute dropdown-menu dropdown-menu-right text-center" aria-labelledby="navbarLoginDropdown">
				<a class="dropdown-item" href="{{ route('login', app()->getLocale()) }}">{{ __('auth.Login') }}</a>
				@if (Route::has('register'))
					<a class="dropdown-item" href="{{ route('register', app()->getLocale()) }}">{{ __('auth.Register') }}</a>
				@endif
			</div>
		</div>
	</div>
@else

	<ul class="nav">
		@if($messageCount>0)
			<li class="nav-item">
				<a data-toggle="modal" data-target="#modal-template" class="mr-3 mr-md-0 nav-link sup-not" onclick="Message.index('{{ route('message.index',app()->getLocale()) }}');"><span class="fa">&#xf0e0;</span><sup class="">{{ $messageCount }}</sup></a>
			</li>
		@endif

		@if($notificationCount>0)
			<li class="nav-item">
				<a data-toggle="modal" data-target="#modal-template" class="mr-3 mr-md-0 nav-link sup-not" onclick="Notification.show('{{ route('notification.index',app()->getLocale()) }}');"><span class="fa">&#xf0f3;</span><sup class="">{{ $notificationCount }}</sup></a>
			</li>
		@endif

		<li class="nav-item">
			<a href="#" class="nav-link" onclick="openNav();">
				{{ Auth::user()->name }} <i class="fa fa-caret-left"></i>
			</a>
		</li>
	</ul>

	<div id="small-menu-links">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

		<a data-toggle="modal" data-target="#modal-template" class="dropdown-item" style="cursor:pointer;" onclick="Message.index('{{ route('message.index',app()->getLocale()) }}');">{{ __('message.Messages') }}</a>
		<a class="dropdown-item" href="{{ route('post.create',app()->getLocale()) }}">{{ __('post.Add post') }}</a>
		<a class="dropdown-item" href="{{ route('post.draft',app()->getLocale()) }}">{{ __('post.Draft') }}</a>
		<a class="dropdown-item" href="{{ route('user.profile',[app()->getLocale()]) }}">{{ __('user.My profile') }}</a>
		@if(\Auth::user()->balance>0)
			<a class="dropdown-item" data-toggle="modal" data-target="#modal-template" onClick="withdrawl('{{ route('user.withdrawl',[app()->getLocale()]) }}');">{{ __('user.Balance').': €'.\Auth::user()->balance }}</a>
		@endif
		@if(\Auth::user()->is_admin==1)
			<a href="{{ route('user.withdrawlModeration',[app()->getLocale()]) }}" class="dropdown-item">{{ __('user.Withdrawl moderation') }}</a>
		@endif
		<a class="dropdown-item" href="{{ route('logout', app()->getLocale()) }}"
		   onclick="event.preventDefault();
						 document.getElementById('logout-form').submit();">
			{{ __('auth.Logout') }}
		</a>

		<form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
			@csrf
		</form>
	</div>
@endif