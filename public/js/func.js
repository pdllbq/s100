function rand(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}


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
	var amount=$('#modal-template #withdrawl-input-amount').val();
	var fullName=$('#modal-template #withdrawl-input-full-name').val();
	var bankAccountNumber=$('#modal-template #withdrawl-input-bank-account-number').val();
	var ethWallet=$('#modal-template #withdrawl-input-eth-wallet').val();
	var otherInfo=$('#modal-template #withdrawl-input-other').val();

	var bank=$('#modal-template input[name=bank]').val();
	var eth=$('#modal-template input[name=eth]').val();
	var other=$('#modal-template input[name=other]').val();

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

function openModal(url){
	$.getJSON(url,function(data){
		$('#modal-template .modal-title').html(data.title);
		$('#modal-template .modal-body').html(data.body);
		$('#modal-template .modal-footer').html(data.footer);
	});

	$('#modal-template').modal('show');
}

function earnInfo(lang)
{
	if(lang=='ru'){
		window.location.href='https://s100.lv/ru/r/s100lv/zarabotok-na-napisanie-tekstov-na-saite-s100lv';
	}else{
		window.location.href='https://s100.lv/lv/r/s100lv-info/veidojat-rakstu-un-sanemiet-par-to-naudu';
	}
}

function embedTiktok(videoUrl,videoId,spanIdSalt)
{
    var text=$('#embedTiktok_'+videoId+'_'+spanIdSalt).text();
    if(text=='Loading TikTok...'){
        var html='<div class="tiktokStart"></div><blockquote class="tiktok-embed" cite="'+videoUrl+'" data-video-id="'+videoId+'" style="max-width: 605px;min-width: 325px;" > <section> <a target="_blank" title="" href="https://www.tiktok.com/@charlidamelio"></a> <a target="_blank" title="" href=""></a> </section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script><div class="tiktokEnd"></div>';

	console.log('embed tiktok: '+videoId+' '+spanIdSalt);

	$('#embedTiktok_'+videoId+'_'+spanIdSalt).html(html);
    }
}

function resizeIframe(obj) {
	console.log(obj.contentWindow.document.body.offsetHeight + 'px');

	obj.style.height=0;
  obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}
