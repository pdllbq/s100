class Subscribe
{
	static user(url,htmlClass)
	{
		$.get(url,function(data){
			
			if(htmlClass.match(/btn-primary/g)!=null){
				$('div #subscribe-button').removeClass('btn-primary');
				$('div #subscribe-button').addClass('btn-secondary');
			}else{
				$('div #subscribe-button').removeClass('btn-secondary');
				$('div #subscribe-button').addClass('btn-primary');
			}
		});
	}
	
	static tag(url,htmlClass)
	{
		$.get(url,function(data){
			if(htmlClass.match(/btn-primary/g)!=null){
				$('div #subscribe-button').removeClass('btn-primary');
				$('div #subscribe-button').addClass('btn-secondary');
			}else{
				$('div #subscribe-button').removeClass('btn-secondary');
				$('div #subscribe-button').addClass('btn-primary');
			}
		});
	}
	
	static group(url,htmlClass)
	{
		$.get(url,function(data){
			if(htmlClass.match(/btn-primary/g)!=null){
				$('div #subscribe-button').removeClass('btn-primary');
				$('div #subscribe-button').addClass('btn-secondary');
			}else{
				$('div #subscribe-button').removeClass('btn-secondary');
				$('div #subscribe-button').addClass('btn-primary');
			}
		});
	}
}