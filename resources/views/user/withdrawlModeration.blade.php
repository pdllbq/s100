@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-12">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">{{ __('user.User name') }}</th>
						<th scope="col">{{ __('user.Amount') }}</th>
						<th scope="col">{{ __('user.Full name') }}</th>
						<th scope="col">{{ __('user.Bank account number') }}</th>
						<th scope="col">{{ __('user.Action') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $arr)
						<tr>
							<td><a href="{{ route('user.show',[\App()->getLocale(),$arr['user_name']]) }}">&#64;{{ $arr['user_name'] }}</a></td>
							<td>€{{ $arr['amount'] }}</td>
							<td>{{ $arr['full_name'] }}</td>
							<td>{{ $arr['bank_account_number'] }}</td>
							<td><a href="{{ route('user.withdrawlWithdrawed',[\app()->getLocale(),$arr['id']]) }}" class="btn btn-primary">{{ __('user.Withdrawed') }}</a> <a href="{{ route('user.withdrawlReturnToBalance',[\app()->getLocale(),$arr['id']]) }}" class="btn btn-primary">{{ __('user.Return to balance') }}</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
			@if($data->count()==0)
				<div class="aletr alert-primary">{{ __('user.No request for withdrawl') }}</div>
			@endif
		</div>
	</div>
</div>

@endsection
