function ratingMinus(slug,lang)
{
	$.getJSON('/'+lang+'/post/minus/'+slug, function(){
		
	})
	.done(function(data){
		if(data.auth==1){
			$(location).attr('href',data.redirect);
		}else{
			$('#rating_'+slug).text(data.rating);
			
			if($('#button-minus-'+slug).hasClass('minus-active')){
				$('#button-minus-'+slug).removeClass('minus-active');
			}else{
				$('#button-minus-'+slug).addClass('minus-active');
				$('#button-plus-'+slug).removeClass('plus-active');
			}
		}
		
	})
	.fail(function(){
		alert('Network Error');
	});
}

function ratingPlus(slug,lang)
{
	$.getJSON('/'+lang+'/post/plus/'+slug, function(){
		
	})
	.done(function(data){
		if(data.auth==1){
			$(location).attr('href',data.redirect);
		}else{
			$('#rating_'+slug).text(data.rating);
			
			if($('#button-plus-'+slug).hasClass('plus-active')){
				$('#button-plus-'+slug).removeClass('plus-active');
			}else{
				$('#button-plus-'+slug).addClass('plus-active');
				$('#button-minus-'+slug).removeClass('minus-active');
			}
		}
		
	})
	.fail(function(){
		alert('Network Error');
	});
}