function showImage(url)
{
	var win = window.open(url, '_blank');
	win.focus();
}

function withdrawl(url)
{
	$.getJSON(url,function(data){
		$('.modal-title').html(data.title);
		$('.modal-body').html(data.body);
		$('.modal-footer').html(data.footer);
	});
}


function withdrawlSave(url)
{
	var amount=$('#withdrawl-input-amount').val();
	var fullName=$('#withdrawl-input-full-name').val();
	var bankAccountNumber=$('#withdrawl-input-bank-account-number').val();
	var ethWallet=$('#withdrawl-input-eth-wallet').val();
	var otherInfo=$('#withdrawl-input-other').val();
	
	var bank=$('input[name=bank]').val();
	var eth=$('input[name=eth]').val();
	var other=$('input[name=other]').val();
	
	$.getJSON(url,{
			amount:amount,
			full_name:fullName,
			bank_account_number:bankAccountNumber,
			eth_wallet:ethWallet,
			other_info:otherInfo,
			bank:bank,
			eth:eth,
			other:other
		},function(data){
		if(data.error){
			$('.modal-body').prepend('<div class="alert alert-danger">'+data.error+'</div>');
		}else if(data.success){
			$('.modal-body').html('<div class="alert alert-success">'+data.success+'</div>');
			$('.modal-footer').html('');
		}
	});
}

function openNav()
{
	$('#small-menu-links').css('width','250');
}

function closeNav()
{
	$('#small-menu-links').css('width','0');
}