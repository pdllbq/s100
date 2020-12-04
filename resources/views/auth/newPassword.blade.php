@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New password</div>
				@include('/include._messages')
                <div class="card-body">
	                    <form method="POST" action="{{ route('password.saveNewPassword', app()->getLocale()) }}">
                        @csrf
						<div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>
						
                        <div class="form-group row">
                            <label for="new_password_token" class="col-md-4 col-form-label text-md-right">Token (sended to your e-mail)</label>

                            <div class="col-md-6">
                                <input id="new_password_token" type="text" class="form-control" name="new_password_token" value="{{ old('new_password_token') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new_password" class="col-md-4 col-form-label text-md-right">New password</label>

                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="new_password" required>
                            </div>
                        </div>
						
						<div class="form-group row">
                            <label for="new_password2" class="col-md-4 col-form-label text-md-right">Repeat new password</label>

                            <div class="col-md-6">
                                <input id="new_password2" type="password" class="form-control" name="new_password2" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button id="new_password_button" type="submit" class="btn btn-primary">
                                    Save password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection