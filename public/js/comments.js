class Comments
{
	static getAnswers(url,htmlId)
	{
		$.get(url,function(data){
			$('#'+htmlId).html(data);
			
		}).done(function(){
			var hash=$(location).attr('hash');
			
			if(hash!==''){
				if(typeof $(hash).offset()!=='undefined'){
					$('html, body').animate({
						scrollTop: $(hash).offset().top
					}, 0);
				}
			}
		});
	}
}