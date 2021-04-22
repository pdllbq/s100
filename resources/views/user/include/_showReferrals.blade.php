<table class="table table-bordered">
	<thead>
		<tr>
			<th>{{ __('user.Name') }}</th>
			<th>{{ __('user.Earned for you') }}</th>
		</tr>
	</thead>
	
	<tbody>
		@foreach($referrals as $referral)
			<tr>
				<td><a href="{{ route('user.show',[app()->getLocale(),$referral->name]) }}">&commat;{{ $referral->name }}</a></td>
				<td>€{{ @$referral->total_earned/100*10 }}</td>
			</tr>
		@endforeach
	</tbody>


</table>