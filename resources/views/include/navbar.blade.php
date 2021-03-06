<nav class="navbar navbar-expand-md navbar-custom">
	<div class="container-fluid">
		<?php
		$brand=explode('.',$_SERVER['SERVER_NAME']);
		?>
		<a class="navbar-brand" href="{{ url('/'.app()->getLocale()) }}">
			@if($brand[0]!='localhost')
				<span class="domain">{{ $brand[0] }}</span>.<span class="zone">{{ $brand[1] }}</span>
			@else
			<span class="domain">{{ $brand[0] }}</span>
			@endif
		</a>

		<div class="btn btn-add-post">{{ __('post.Add post') }}</div>

		@if($messageCount>0)

		@endif

		@if($notificationCount>0)
			<div class="d-block d-md-none mx-auto order-0">
				<a data-toggle="modal" data-target="#modal-template" class="nav-link sup-not" onclick="Notification.show('{{ route('notification.index',app()->getLocale()) }}');"><span class="fa">&#xf0f3;</span><sup class="">{{ $notificationCount }}</sup></a>
			</div>
		@endif

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
			<span class="fa fa-bars"></span>
		</button>



		@if($messageCount>0)

			<a data-toggle="modal" data-target="#modal-template" class="nav-link mx-auto sup-not" onclick="Message.index('{{ route('message.index',app()->getLocale()) }}');"><span class="fa">&#xf0e0;</span><sup class="">{{ $messageCount }}</sup></a>

		@endif

		@if($notificationCount>0)
			<li class="d-none d-md-block">
				<a data-toggle="modal" data-target="#modal-template" class="nav-link mx-auto sup-not" onclick="Notification.show('{{ route('notification.index',app()->getLocale()) }}');"><span class="fa">&#xf0f3;</span><sup class="">{{ $notificationCount }}</sup></a>
			</li>
		@endif
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

						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								{{ Auth::user()->name }} <span class="caret"></span>
							</a>

							<div class="dropdown-menu dropdown-menu-right dropdown-secondary" aria-labelledby="navbarDropdown">
								<a data-toggle="modal" data-target="#modal-template" class=" dropdown-item mx-auto" style="cursor:pointer;" onclick="Message.index('{{ route('message.index',app()->getLocale()) }}');">{{ __('message.Messages') }}</a>
								<a class="dropdown-item" href="{{ route('post.create',app()->getLocale()) }}">{{ __('post.Create') }}</a>
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
<!--						<li class="nav-item dropdown">
						<a id="LanguageDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
							{{ __('user.Language') }} <span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{ route('user.setLang','lv') }}">Latviešu</a>
							<a class="dropdown-item" href="{{ route('user.setLang','ru') }}">Русский</a>
							<a class="dropdown-item" href="{{ route('user.setLang','en') }}">English</a>
						</div>
					</li>-->
				</ul>
			</div>
	</div>
</nav>
