<div class="collapse navbar-collapse" id="navbarSupportedContent">
	<!-- Left Side Of Navbar -->
	<ul class="navbar-nav mx-auto">

	</ul>

	<!-- Right Side Of Navbar -->
	<ul class="navbar-nav ml-auto">
		<!-- Authentication Links -->
		@guest
			<li class="nav-item">
				<a class="nav-link" href="{{ route('login', app()->getLocale()) }}">{{ __('auth.Login') }}</a>
			</li>
			@if (Route::has('register'))
				<li class="nav-item">
					<a class="nav-link" href="{{ route('register', app()->getLocale()) }}">{{ __('auth.Register') }}</a>
				</li>
			@endif
		@else
		
			@if($messageCount>0)
				<li class="nav-item">
					<a data-toggle="modal" data-target="#modal-template" class="nav-link mx-auto sup-not" onclick="Message.index('{{ route('message.index',app()->getLocale()) }}');"><span class="fa">&#xf0e0;</span><sup class="">{{ $messageCount }}</sup></a>
				</li>
			@endif

			@if($notificationCount>0)
				<li class="nav-item">
					<a data-toggle="modal" data-target="#modal-template" class="nav-link mx-auto sup-not" onclick="Notification.show('{{ route('notification.index',app()->getLocale()) }}');"><span class="fa">&#xf0f3;</span><sup class="">{{ $notificationCount }}</sup></a>
				</li>
			@endif

			<li class="nav-item">
				<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ Auth::user()->name }} <span class="caret"></span>
				</a>

				<div class="dropdown-menu dropdown-menu-right dropdown-secondary" aria-labelledby="navbarDropdown">
					<a data-toggle="modal" data-target="#modal-template" class=" dropdown-item mx-auto" style="cursor:pointer;" onclick="Message.index('{{ route('message.index',app()->getLocale()) }}');">{{ __('message.Messages') }}</a>
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
			</li>
		@endguest
		
		@if(app()->getLocale()=='lv')
			<a href="{{ route('user.setLang','ru') }}" class="nav-link" title="По русски">По русски</a>
		@elseif(app()->getLocale()=='ru')
			<a href="{{ route('user.setLang','lv') }}" class="nav-link" title="Latviski">Latviski</a>
		@endif
		</li>
	</ul>
</div>