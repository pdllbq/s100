<div class="card">
	<div class="card-header">{{ __('user.Referral link') }}</div>
	<div class="card-body">
		
		<div class="col-12"> {{ __('user.Referral description') }} </div><br>
		
		<div class="col-12">
			<div class="form-group">
				<input class="form-control" value="https://{{ $_SERVER['SERVER_NAME'] }}/{{ \App()->getLocale() }}/?referral={{ $user->name }}">
			</div>
		</div>
		
		<div class="col-12">
			
			<div class="btn-link" style="cursor:pointer;" onclick="openModal('{{ route('user.showReferrals',[\App()->getLocale()]) }}')">{{ __('user.Referrals') }}: {{ $referralCount }}</div>
			
		</div>
		
	</div>
</div>

