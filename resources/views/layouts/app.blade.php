<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	@if (trim($__env->yieldContent('noindex')))
		<meta name="robots" content="noindex">
	@endif

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

		<script src="{{ asset('js/app.js') }}" ></script>
	<script src="{{ asset('js/popper.js') }}" ></script>
	<script src="{{ asset('js/func.js?5') }}" ></script>
	<script src="{{ asset('js/rating.js') }}" ></script>
	<script src="{{ asset('js/comments.js') }}" ></script>
	<script src="{{ asset('js/subscribe.js') }}" ></script>
	<script src="{{ asset('js/group.js') }}" ></script>
	<script src="{{ asset('js/messages.js') }}" ></script>
	<script src="{{ asset('js/notification.js') }}" ></script>
	<script src="{{ asset('js/summernote.js') }}" ></script>
	<script src="{{ asset('js/summernote-ru.js') }}" ></script>
	<script src="{{ asset('js/summernote-lv.js') }}" ></script>
	<script src="{{ asset('js/post.js') }}" ></script>


    <!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css?5') }}" rel="stylesheet">
	<link href="{{ asset('css/summernote.css') }}" rel="stylesheet">

	@if($_SERVER['SERVER_NAME']=='s100.lv')
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-83Q09504VE"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-83Q09504VE');
		</script>
	@endif

</head>

<?php
if(isset(\Auth::user()->id)){
	$notificationCount= \App\Models\Notification::where('user_id',\Auth::user()->id)->where('readed',0)->count();
	$messageCount=\App\Models\Message::where('owner_name',\Auth::user()->name)->where('to_name',\Auth::user()->name)->where('readed',0)->count();
}else{
	$notificationCount=0;
	$messageCount=0;
}
?>

<body>
	<!-- Load Facebook SDK for JavaScript -->
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v10.0&appId=660737471254649&autoLogAppEvents=1" nonce="CLPua9bo"></script>

    <div id="app">
        @include('include.navbar2')

        <main class="py-4">
            @yield('content')
        </main>
		@include('include._modal')
    </div>

	<div class="footer">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-6">
					<div class="col-12 h2">
						{{ __('main.Useful') }}
					</div>
					<div>
						<a href="{{ route('holidayCalendar', [\App::getLocale(), 2024]) }}">{{ __('main.Holiday calendar :year',['year'=>2024]) }}</a>
					</div>
				</div>
				<div class="col-12 col-lg-6">
					<div class="h2">
						{{ __('main.About site') }}
					</div>
					@if(\App::getLocale()=='ru')
						<div>
							<a href="https://s100.lv/ru/r/s100lv/zarabotok-na-napisanie-tekstov-na-saite-s100lv">{{ __('main.Whrite and earn') }}</a>
						</div>
						<div>
							<a href="https://s100.lv/ru/r/s100lv/priglasai-druzei-i-polucai-10-ot-ix-zarabotka">Партнёрская программа</a>
						</div>
					@else
						<div>
							<a href="https://s100.lv/lv/r/s100lv-info/veidojat-rakstu-un-sanemiet-par-to-naudu">{{ __('main.Whrite and earn') }}</a>
						</div>
					@endif
				</div>
				<div class="col-12">
					<a href="{{ route('rss',[app()->getLocale()]) }}" target="_blank" title="RSS">
						<i class="fas fa-rss"></i>
					</a>
				</div>
				<div class="col-12">
					&copy;2020 - {{  now()->year }} &laquo;<a href="/">{{ $_SERVER['SERVER_NAME'] }}</a>&raquo;
				</div>
			</div>
		</div>
	</div>

</body>
</html>
