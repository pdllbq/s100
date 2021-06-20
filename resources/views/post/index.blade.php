@extends('layouts.app')

@section('title',$title)

@if(isset($description))
	@section('description',$description)
@endif

@section('content')

@include('include._messages')

<div class="container">
	<div class="row">
		<div class="d-block d-lg-none col-12">
			<div class="menu text-center">
					<span class=" {{ \Route::currentRouteName()=='home'?'text-underline':'' }}"><a href="{{ route('home',[app()->getLocale()]) }}">{{ __('post.Best') }}</a></span> |
					@Auth
					<span class=" {{ \Route::currentRouteName()=='post.subscribes'?'text-underline':'' }}"><a href="{{ route('post.subscribes',[app()->getLocale()]) }}">{{ __('post.Subscribes') }}</a></span> |
					@Endauth
					<span class=" {{ \Route::currentRouteName()=='post.new'?'text-underline':'' }}"><a href="{{ route('post.new',[app()->getLocale()]) }}">{{ __('post.New') }}</a></span> |
					<span class=" {{ \Route::currentRouteName()=='post.sandbox'?'text-underline':'' }}"><a href="{{ route('post.sandbox',[app()->getLocale()]) }}">{{ __('post.Sandbox') }}</a></span>
					@auth
						|<span id="xs-additional-navigation-show-button" class="btn btn-link" onClick="$('#xs-additional-navigation-show-button').hide(); $('#xs-additional-navigation').show();">&gt;&gt;</span>
						<span id="xs-additional-navigation" style="display:none;">
							<span class=" {{ \Route::currentRouteName()=='post.readed'?'text-underline':'' }}"><a href="{{ route('post.readed',[app()->getLocale()]) }}">{{ __('post.Readed') }}</a></span>
							| <span class=" {{ \Route::currentRouteName()=='post.iLike'?'text-underline':'' }}"><a href="{{ route('post.iLike',[app()->getLocale()]) }}">{{ __('post.You liked') }}</a></span>
							@if(\Auth::user()->is_moder==1)
								| <span class=" {{ \Route::currentRouteName()=='post.moder'?'text-underline':'' }}"><a href="{{ route('post.moder',[app()->getLocale()]) }}">{{ __('post.Moderation') }}</a></span>
							@endif
						</span>
					@endauth
			</div>
		</div>
		
		
		<div class="col-12 d-lg-none">
		@if(\Route::currentRouteName()=='group.show')
			<div class="card">
				<div class="card-header text-center">{{ $group->name }}</div>
				<div class="card-body">
					<div class="">
						{{ $group->description }}
					</div>
					@auth
						<?php
						if($subscribed==0){
							$class='btn-primary';
						}else{
							$class='btn-secondary';
						}
						?>
						<div>{{ __('post.Subscribers') }}: {{ $subscribers }}</div>
						<div id="subscribe-button" class="btn {{ $class }} d-flex justify-content-center" onclick="Subscribe.group('{{ route('subscribe.group',[app()->getLocale(),$group->slug]) }}',this.className);"><i class="fa fa-bell" aria-hidden="true"> {{ __('user.Subscribe') }}</i></div>
					@endauth
				</div>
			</div>
			<br>
		@endif
		</div>
		
		<div class="d-block d-lg-none col-12">
			@if(\Route::currentRouteName()=='post.tag')
				<div class="card">
					<div class="card-header text-center">#{{ $tag }}</div>
					<div class="card-body">
						<div>{{ __('post.Subscribers') }}: {{ $subscribers }}</div>
						@auth
							<?php
							if($subscribed==0){
								$class='btn-primary';
							}else{
								$class='btn-secondary';
							}
							?>
							<div id="subscribe-button" class="btn {{ $class }} d-flex justify-content-center" onclick="Subscribe.tag('{{ route('subscribe.tag',[app()->getLocale(),$tag]) }}',this.className);"><i class="fa fa-bell" aria-hidden="true"> {{ __('user.Subscribe') }}</i></div>
						@endauth
					</div>
				</div>
				<br>
			@endif
		</div>
		<br>
		
		<div class="col-12 col-lg-9">
			
		@include('include.post._showPosts',['posts'=>$posts])
		<div class="d-block d-lg-none">{{ $posts->onEachSide(0)->links() }}</div>
		<div class="d-none d-lg-block">{{ $posts->onEachSide(3)->links() }}</div>
		
				
		</div>
		<div class="d-none d-lg-block col-md-3">
			@if(\Route::currentRouteName()=='post.tag')
				<div class="card">
					<div class="card-header text-center">#{{ $tag }}</div>
					<div class="card-body">
						<div>{{ __('post.Subscribers') }}: {{ $subscribers }}</div>
						@auth
							<?php
							if($subscribed==0){
								$class='btn-primary';
							}else{
								$class='btn-secondary';
							}
							?>
							<div id="subscribe-button" class="btn {{ $class }} d-flex justify-content-center" onclick="Subscribe.tag('{{ route('subscribe.tag',[app()->getLocale(),$tag]) }}',this.className);"><i class="fa fa-bell" aria-hidden="true"> {{ __('user.Subscribe') }}</i></div>
						@endauth
					</div>
				</div>
				<br>
			@endif
			
			
			
			@if(\Route::currentRouteName()=='group.show')
				<div class="card">
					<div class="card-header text-center">{{ $group->name }}</div>
					<div class="card-body">
						<div class="">
							{{ $group->description }}
						</div>
						@auth
							<?php
							if($subscribed==0){
								$class='btn-primary';
							}else{
								$class='btn-secondary';
							}
							?>
							<div>{{ __('post.Subscribers') }}: {{ $subscribers }}</div>
							<div id="subscribe-button" class="btn {{ $class }} d-flex justify-content-center" onclick="Subscribe.group('{{ route('subscribe.group',[app()->getLocale(),$group->slug]) }}',this.className);"><i class="fa fa-bell" aria-hidden="true"> {{ __('user.Subscribe') }}</i></div>
						@endauth
					</div>
				</div>
				<br>
			@endif
			
			
			<div class="menu">
				<div class="menu-header">{{ __('post.Read') }}</div>
				<div class="menu-body">
					<div class=" {{ \Route::currentRouteName()=='home'?'text-underline':'' }}"><a href="{{ route('home',[app()->getLocale()]) }}">{{ __('post.Best') }}</a></div>
					@Auth
					<div class=" {{ \Route::currentRouteName()=='post.subscribes'?'text-underline':'' }}"><a href="{{ route('post.subscribes',[app()->getLocale()]) }}">{{ __('post.Subscribes') }}</a></div>
					@Endauth
					<div class=" {{ \Route::currentRouteName()=='post.new'?'text-underline':'' }}"><a href="{{ route('post.new',[app()->getLocale()]) }}">{{ __('post.New') }}</a></div>
					<div class=" {{ \Route::currentRouteName()=='post.sandbox'?'text-underline':'' }}"><a href="{{ route('post.sandbox',[app()->getLocale()]) }}">{{ __('post.Sandbox') }}</a></div>
					@auth
						<div class=" {{ \Route::currentRouteName()=='post.readed'?'text-underline':'' }}"><a href="{{ route('post.readed',[app()->getLocale()]) }}">{{ __('post.Readed') }}</a></div>
						<div class=" {{ \Route::currentRouteName()=='post.iLike'?'text-underline':'' }}"><a href="{{ route('post.iLike',[app()->getLocale()]) }}">{{ __('post.You liked') }}</a></div>
						@if(\Auth::user()->is_moder==1)
							<div class=" {{ \Route::currentRouteName()=='post.moder'?'text-underline':'' }}"><a href="{{ route('post.moder',[app()->getLocale()]) }}">{{ __('post.Moderation') }}</a></div>
						@endif
					@endauth
				</div>
				<div class="menu-footer"></div>
			</div>
			
			@if(\Route::currentRouteName()=='home' || \Route::currentRouteName()=='post.new' || \Route::currentRouteName()=='post.subscribes')
				<div class="menu">
					<div class="menu-header">{{ __('user.Top users') }}</div>
					<div class="menu-body">
						@foreach($topUsers as $user)
							<a href="{{ route('user.show',[app()->getLocale(),$user->name]) }}">{{ $user->name }}</a> <br>
						@endforeach
					</div>
					<div class="menu-footer"></div>
				</div>
				<br>
			@endif
			
			@if(\Route::currentRouteName()=='home' || \Route::currentRouteName()=='post.new' || \Route::currentRouteName()=='post.subscribes')
				<div class="menu">
					<div class="menu-header">{{ __('group.Top groups') }}</div>
					<div class="menu-body">
						@foreach($topGroups as $group)
							<a href="{{ route('group.show',[app()->getLocale(),$group->slug]) }}">{{ $group->name }}</a> <br>
						@endforeach
					</div>
					<div class="menu-footer"></div>
				</div>
				<br>
			@endif
	</div>
</div>


@endsection