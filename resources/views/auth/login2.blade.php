<?php
$brand=explode('.',$_SERVER['SERVER_NAME']);
?>

@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row jumbotron vertical-center bg-inherit pt-0">
		<div class="col-12 col-md-6 text-center">
			<div class="my-auto">
				@if($brand[0]!='localhost')
					<h1><span class="text-uppercase domain">{{ $brand[0] }}</span>.<span class="text-uppercase zone">{{ $brand[1] }}</span></h1>
				@else
					<h1><span class="text-uppercase domain">{{ $brand[0] }}</span></h1>
				@endif
			</div>
			<h2>{{ __('auth.Description') }}</h2>
		</div>
		<div class="col-12 col-md-6">
			@include('/include._messages')
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col text-center">
							<a href="/{{ app()->getLocale() }}/login/facebook" class="btn btn-primary facebook-button"><i class="fa fa-facebook"></i> {{ __('auth.Login with Facebook') }}</a>
						</div>
					</div>
					<hr>
					<form method="POST" action="{{ route('login', app()->getLocale()) }}">
                        @csrf
						
						<div class="form-group">
							<label for="email">{{ __('auth.eMail') }}</label>
							<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
							
							@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror	
						</div>
						<div class="form-group">
							<label for="password">{{ __('auth.Password') }}</label>
							<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
							@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<div class="form-group">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
								<label class="form-check-label" for="remember">
									{{ __('auth.Remember Me') }}
								</label>
							</div>
						</div>
						<div class="form-group">
							<button id="login_button" type="submit" class="btn btn-primary btn-lg btn-block">
								{{ __('auth.Enter') }}
							</button>
						</div>
						@if (Route::has('password.request'))
							<a class="btn btn-link btn-block" href="{{ route('password.request', app()->getLocale()) }}">
								{{ __('auth.Forgot Your Password?') }}
							</a>
						@endif
					</form>
					<hr>
					<div class="row">
						<div class="col text-center">
							<a href="{{ route('register',[app()->getLocale()]) }}" class="btn btn-success btn-lg text-center">{{ __('auth.Register') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection