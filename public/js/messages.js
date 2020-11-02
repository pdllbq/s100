class Message
{
	static index(url)
	{
		$('.modal-content').html('');
		
		$.get(url,function(data){
			$('.modal-content').html(data);
		});
	}
	
	static create(url,userName)
	{
		$('.modal-content').html('');
		
		$.get(url,function(data){
			$('.modal-content').html(data);
			$('#modal-template').modal('show');
		});
	}
	
	static store(url)
	{
		var userName=$('#user_name').val();
		var message=$('#message_text').val();
		var _token=$('input[name=_token]').val();
		
		var data={
			user_name:userName,
			message:message,
			_token:_token
		};
		
		$.post(url,data)
				.done(function (data){
					$('.modal-content').html(data);
		});
	}
	
	static show(url)
	{
		$('.modal-content').html('');
		
		$.get(url,function(data){
			$('.modal-content').html(data);
		});
	}
	
	static delete(url,indexUrl)
	{
		$.get(url,function(data){
			Message.index(indexUrl);
		});
	}
}