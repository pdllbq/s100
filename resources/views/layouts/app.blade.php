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
	<script src="{{ asset('js/popper.js') }}" ></script>
	<script src="{{ asset('js/app.js') }}" ></script>
	<script src="{{ asset('js/func.js?1') }}" ></script>
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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css?2') }}" rel="stylesheet">
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
		&copy;2020 &laquo;<a href="/">{{ $_SERVER['SERVER_NAME'] }}</a>&raquo; v:0.01
	</div>
	
</body>
</html>
