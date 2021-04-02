<nav class="navbar navbar-expand-md navbar-custom" id="nav-links">
	<!--Brand -->
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
	
	<!-- New post button -->
	<a href="{{ route('post.create',[app()->getLocale()]) }}" class="d-block d-sm-none btn btn-add-post nav-link mr-auto" title="{{ __('post.Add post') }}"><i class="fa fa-edit"></i></a>
	<a href="{{ route('post.create',[app()->getLocale()]) }}" class="d-none d-sm-block btn btn-add-post nav-link mr-auto"><i class="fa fa-edit"></i> {{ __('post.Add post') }}</a>
	
	<div class="navbar-nav">
		
		<div class="d-md-none d-lg-block" id="navbarSupportedContent">
			@include('include.navbar.menuLarge')
		</div>
		<div class="d-xs-block d-lg-none" id="navbarSupportedContent">
			@include('include.navbar.menuSmall')
		</div>
	</div>
</nav>
