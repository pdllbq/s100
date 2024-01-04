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

function insertInfo(lang, divId)
{
	
	var settings = {
		'cache': false,
		"async": true,
		"crossDomain": true,
		"url": "https://info.vlz.lv/"+lang+"/info/get",
		"method": "GET",
		"dataType": "html",
		"headers": {
			"accept": "atext/html",
			"Access-Control-Allow-Origin":"*"
		}
	}

	$.ajax(settings).done(function (data) {
		$("#"+divId).html(data);
	});
}

function newsSourceEdit(divId,lang,sourceId,sourceUrl, sourceLang)
{
	$('#'+divId).modal('show');

	$('#edit_source_url').val(sourceUrl);
	$('#edit_source_lang').val(sourceLang);
	$('#edit_source_id').val(sourceId);
}

function newsSourceEditSave(modalId,successId,route)
{
	var sourceUrl=$('#edit_source_url').val();
	var sourceLang=$('#edit_source_lang').val();
	var sourceId=$('#edit_source_id').val();
	var _token=$('[name=_token]').val();

	$.post(route,{
		edit_source_url:sourceUrl,
		edit_source_lang:sourceLang,
		edit_source_id:sourceId,
		_token:_token
	},function(data){
		if(data.error){
			console.log(data.error);
			$('#edit_source_modal_error').html(data.error);
			$('#edit_source_modal_error').show();
		}else if(data.success){
			console.log(data.success);
			$('#edit_source_modal_error').hide();
			$('#'+modalId).modal('hide');
			location.reload();
			window.scrollTo(0, 0);
		}
	},'json');
}

function newsSourceDelete(question, route)
{
	if(confirm(question)){
		window.location.href=route;
	}
}

function newsFilterEdit(modalId, filterId, name, lang)
{
	$('#'+modalId).modal('show');

	$('#edit_filter_name').val(name);
	$('#edit_filter_lang').val(lang);
	$('#edit_filter_id').val(filterId);
}

function newsFilterEditSave(route)
{
	var id = $('#edit_filter_id').val();
	var name = $('#edit_filter_name').val();
	var lang = $('#edit_filter_lang').val();
	var _token = $('[name=_token]').val();

	$.post(route,{
		edit_filter_id:id,
		edit_filter_name:name,
		edit_filter_lang:lang,
		_token:_token
	},function(data){
		if(data.error){
			console.log(data.error);
			$('#edit_filter_modal_error').html(data.error);
			$('#edit_filter_modal_error').show();
		}else if(data.success){
			console.log(data.success);
			$('#edit_filter_modal_error').hide();
			$('#edit_filter_modal').modal('hide');
			location.reload();
			window.scrollTo(0, 0);
		}
	},'json');
}

function newsFilterDelete(question, route)
{
	if(confirm(question)){
		window.location.href=route;
	}
}