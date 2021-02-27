<form>
	<div class="form-group">
		
		<label for="withdrawl-input-amount">{{ __('user.Amount') }} €</label>
		<input type="text" class="form-control" id="withdrawl-input-amount" name="withdrawl-input-amount" value="{{ $balance }}">
		<label for="withdrawl-input-full-name">{{ __('user.Full name') }}</lable>
		<input class="form-control" type="text" id="withdrawl-input-full-name" name="withdrawl-input-full-name" placeholder="{{ __('user.Name Surname') }}">
		<label for="withdrawl-input-bank-account-number">{{ __('user.Bank account number') }}</label>
		<input class="form-control" type="text" id="withdrawl-input-bank-account-number" name="withdrawl-input-bank-account-number" placeholder="LV86HABA0551014522861">
	</div>
</form>