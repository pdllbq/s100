<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="icon" type="image/x-icon" href="/favicon.ico">
	
	@if (trim($__env->yieldContent('title')))
		<title>@yield('title') - {{ strtoupper($_SERVER['SERVER_NAME']) }}</title>
	@else
		<title>{{ strtoupper($_SERVER['SERVER_NAME']) }}</title>
	@endif
	
	@if (trim($__env->yieldContent('description')))
		<meta name="description" content="@yield('description')">
	@endif
	
	@if (trim($__env->yieldContent('keywords')))
		<meta name="keywords" content="@yield('keywords')">
	@endif

    <!-- Scripts -->
	<script src="{{ asset('js/jquery.js') }}" ></script>
	<script src="{{ asset('js/popper.js') }}" ></script>
	<script src="{{ asset('js/app.js') }}" ></script>
	<script src="{{ asset('js/func.js') }}" ></script>
	<script src="{{ asset('js/rating.js') }}" ></script>
	<script src="{{ asset('js/comments.js') }}" ></script>
	<script src="{{ asset('js/subscribe.js') }}" ></script>
	<script src="{{ asset('js/group.js') }}" ></script>
	<script src="{{ asset('js/messages.js') }}" ></script>
	<script src="{{ asset('js/notification.js') }}" ></script>
	<script src="{{ asset('js/summernote.js') }}" ></script>
	<script src="{{ asset('js/summernote-ru.js') }}" ></script>
	<script src="{{ asset('js/summernote-lv.js') }}" ></script>
	

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/summernote.css') }}" rel="stylesheet">
	
</head>

<?php
if(isset(\Auth::user()->id)){
	$notificationCount= \App\Models\Notification::where('user_id',\Auth::user()->id)->where('readed',0)->count();
	$messageCount=\App\Models\Message::where('to_name',\Auth::user()->name)->where('readed',0)->count();
}else{
	$notificationCount=0;
	$messageCount=0;
}
?>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-custom">
            <div class="container-fluid">
				<?php
				$brand=explode('.',$_SERVER['SERVER_NAME']);
				?>
                <a class="navbar-brand" href="{{ url('/'.app()->getLocale()) }}">
                    <span class="domain">{{ $brand[0] }}</span>.<span class="zone">{{ $brand[1] }}</span>
                </a>
				
				@if($messageCount>0)
					<div class="d-block d-md-none mx-auto order-0">
						<a data-toggle="modal" data-target="#modal-template" class="nav-link mx-auto sup-not" onclick="Message.index('{{ route('message.index',app()->getLocale()) }}');"><span class="fa">&#xf0e0;</span><sup class="">{{ $messageCount }}</sup></a>
					</div>
				@endif
				
				@if($notificationCount>0)
					<div class="d-block d-md-none mx-auto order-0">
						<a data-toggle="modal" data-target="#modal-template" class="nav-link mx-auto sup-not" onclick="Notification.show('{{ route('notification.index',app()->getLocale()) }}');"><span class="fa">&#xf0f3;</span><sup class="">{{ $notificationCount }}</sup></a>
					</div>
				@endif
				
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="fa fa-bars"></span>
                </button>

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
							<li class="d-none d-md-block">
								<a data-toggle="modal" data-target="#modal-template" class="nav-link mx-auto sup-not" onclick="Message.index('{{ route('message.index',app()->getLocale()) }}');"><span class="fa">&#xf0e0;</span><sup class="">{{ $messageCount }}</sup></a>
							</li>
						@endif
						
						@if($notificationCount>0)
							<li class="d-none d-md-block">
								<a data-toggle="modal" data-target="#modal-template" class="nav-link mx-auto sup-not" onclick="Notification.show('{{ route('notification.index',app()->getLocale()) }}');"><span class="fa">&#xf0f3;</span><sup class="">{{ $notificationCount }}</sup></a>
							</li>
						@endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-secondary" aria-labelledby="navbarDropdown">
									<a data-toggle="modal" data-target="#modal-template" class=" dropdown-item mx-auto" style="cursor:pointer;" onclick="Message.index('{{ route('message.index',app()->getLocale()) }}');">{{ __('message.Messages') }}</a>
									<a class="dropdown-item" href="{{ route('post.create',app()->getLocale()) }}">{{ __('post.Create') }}</a>
									<a class="dropdown-item" href="{{ route('user.profile',[app()->getLocale()]) }}">{{ __('user.My profile') }}</a>
									
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

        <main class="py-4">
            @yield('content')
        </main>
		@include('include._modal');	
    </div>
	
	<div class="footer">
		&copy;2020 &laquo;<a href="/">{{ $_SERVER['SERVER_NAME'] }}</a>&raquo; v:0.01
	</div>
	
</body>
</html>
