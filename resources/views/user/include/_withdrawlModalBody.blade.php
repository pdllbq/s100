<div class="col-12 text-center">
	<div class="btn-group btn-group-toggle" data-toggle="buttons">
		<label class="btn btn-secondary active" id="bankButton">
			<input type="radio" name="withdrawl-type" value="bank" checked>Банк</input>
		</label>
		<label class="btn btn-secondary" id="ethButton">
			<input type="radio" name="withdrawl-type" value="eth">ETH</input>
		</label>
		<label class="btn btn-secondary" id="otherButton">
			<input type="radio" name="withdrawl-type" value="other">Другой</input>
		</label>
	</div>
</div>



<form>
	<div class="form-group">
		<label for="withdrawl-input-amount">{{ __('user.Amount') }} €</label>
		<input type="text" class="form-control" id="withdrawl-input-amount" name="withdrawl-input-amount" value="{{ $balance }}">
	</div>
	<div class="form-group" id="group-input-full-name">
		<label for="withdrawl-input-full-name">{{ __('user.Full name') }}</label>
		<input class="form-control" type="text" id="withdrawl-input-full-name" name="withdrawl-input-full-name" placeholder="{{ __('user.Name Surname') }}">
	</div>
	<div class="form-group d-none" id="group-input-eth-wallet">
		<label for="withdrawl-input-eth-wallet">{{ __('user.ETH wallet') }}</label>
		<input class="form-control" type="text" id="withdrawl-input-eth-wallet" name="withdrawl-input-eth-wallet">
	</div>
	<div class="form-group d-none" id="group-input-other">
		<label for="withdrawl-input-other">{{ __('user.Withdrawl other') }}</label>
		<textarea class="form-control" type="text" id="withdrawl-input-other" name="withdrawl-input-other"></textarea>
	</div>
	<div class="form-group" id="group-input-bank-account-number">
		<label for="withdrawl-input-bank-account-number">{{ __('user.Bank account number') }}</label>
		<input class="form-control" type="text" id="withdrawl-input-bank-account-number" name="withdrawl-input-bank-account-number" placeholder="LV86HABA0551014522861">
	</div>
	<input type="hidden" name="bank" value="1">
	<input type="hidden" name="eth" value="0">
	<input type="hidden" name="other" value="0">
</form>

<script>	
	$('#modal-template #ethButton').click(function(event){
		$('#modal-template input[name=bank]').val('0');
		$('#modal-template input[name=eth]').val('1');
		$('#modal-template input[name=other]').val('0')
		
		$('#modal-template #group-input-full-name').removeClass('d-block');
		$('#modal-template #group-input-full-name').addClass('d-none');
		
		$('#modal-template #group-input-bank-account-number').removeClass('d-block');
		$('#modal-template #group-input-bank-account-number').addClass('d-none');
		
		$('#modal-template #group-input-other').removeClass('d-block');
		$('#modal-template #group-input-other').addClass('d-none');
		
		$('#modal-template #group-input-eth-wallet').removeClass('d-none');
		$('#modal-template #group-input-eth-wallet').addClass('d-block');
	});
	
	$('#modal-template #bankButton').click(function(event){	
		$('#modal-template input[name=bank]').val('1');
		$('#modal-template input[name=eth]').val('0');
		$('#modal-template input[name=other]').val('0')
		
		$('#modal-template #group-input-eth-wallet').removeClass('d-block');
		$('#modal-template #group-input-eth-wallet').addClass('d-none');
		
		$('#modal-template #group-input-other').removeClass('d-block');
		$('#modal-template #group-input-other').addClass('d-none');
		
		$('#modal-template #group-input-full-name').removeClass('d-none');
		$('#modal-template #group-input-full-name').addClass('d-block');
		
		$('#modal-template #group-input-bank-account-number').removeClass('d-none');
		$('#modal-template #group-input-bank-account-number').addClass('d-block');
	});
	
	$('#modal-template #otherButton').click(function(event){
		$('#modal-template input[name=bank]').val('0');
		$('#modal-template input[name=eth]').val('0');
		$('#modal-template input[name=other]').val('1')
		
		$('#modal-template #group-input-full-name').removeClass('d-block');
		$('#modal-template #group-input-full-name').addClass('d-none');
		
		$('#modal-template #group-input-eth-wallet').removeClass('d-block');
		$('#modal-template #group-input-eth-wallet').addClass('d-none');
		
		$('#modal-template #group-input-bank-account-number').removeClass('d-block');
		$('#modal-template #group-input-bank-account-number').addClass('d-none');
		
		$('#modal-template #group-input-other').removeClass('d-none');
		$('#modal-template #group-input-other').addClass('d-block');
	});
</script>