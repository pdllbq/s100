class Notification
{
	static show(url)
	{
		$.get(url,function(data){
			$('.modal-content').html('');
			$('.modal-content').html(data);
		});
	}
	
	static clear(url)
	{
		$.get(url,function(data){
			
		}).done(function(){
			$('#modal-template').modal('hide');
			location.reload();
		});
	}
}