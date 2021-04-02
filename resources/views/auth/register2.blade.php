<?php
$brand=explode('.',$_SERVER['SERVER_NAME']);
?>

@extends('layouts.app')

@section('content')
@if(!$banIp)
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
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col text-center">
								<a href="/{{ app()->getLocale() }}/login/facebook" class="btn btn-primary facebook-button"><i class="fa fa-facebook"></i> {{ __('auth.Login with Facebook') }}</a>
							</div>
						</div>
						<hr>

						
						<form method="POST" action="{{ route('register',app()->getLocale()) }}">
							@csrf

							<div class="form-group">
								<label for="name" class="col-form-label text-md-right">{{ __('auth.Name') }}</label>

								<div class="">
									<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

									@error('name')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="form-group">
								<label for="email" class="col-form-label text-md-right">{{ __('auth.E-Mail Address') }}</label>

								<div class="">
									<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

									@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="form-group">
								<label for="password" class="col-form-label text-md-right">{{ __('auth.Password') }}</label>

								<div class="">
									<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="form-group">
								<label for="password-confirm" class="col-form-label text-md-right">{{ __('auth.Confirm Password') }}</label>

								<div class="">
									<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
								</div>
							</div>

							<div class="form-group mb-0">
								<div class="">
									<button type="submit" class="btn btn-block btn-lg btn-primary">
										{{ __('auth.Register') }}
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@else
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="alert alert-danger">{{ __('user.You are banned') }}</div>
			</div>
		</div>
	</div>
@endif
@endsection
