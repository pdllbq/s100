class Group
{
	static make(url)
	{
		$(document.body).css({ 'cursor': 'wait' })
		$("#addGroup").attr("disabled", true);
		
		var name=$('#name').val();
		var _token=$('[name=_token]').val();
		
		$.post(url,{name:name,_token:_token})
			.done(function(data){
				$(document.body).css({ 'cursor': 'default' })
				$("#addGroup").attr("disabled", false);
				
				if(data.redirect){
					$(location).attr('href',data.redirect);
				}
			})
			.fail(function(data){
				data=data.responseJSON
				
				if(data.errors.name){
					
					var printError='<div class="alert alert-danger" role="alert">'+data.errors.name+'</div>';
					$('#errors-place').html(printError);
				}
				
				$(document.body).css({ 'cursor': 'default' })
				$("#addGroup").attr("disabled", false);
			});
	}
	
	static delete(url,text)
	{
		if(confirm(text)){
			$(location).attr('href',url);
		}
	}
	
	static edit(url,modalId,name,description,slug,id)
	{
		$(modalId).modal('show');
		
		$('#groupName').val(name);
		$('#editUrl').val(url);
		$('#description').val(description);
		$('#editId').val(id)
	}
	
	static store()
	{
		var name=$('#groupName').val();
		var description=$('#description').val();
		var url=$('#editUrl').val();
		var id=$('#editId').val();
		var _token=$('[name=_token]').val();
		
		$.post(url,{name:name,description:description,_token:_token,id:id})
			.done(function(data){
				$(document.body).css({ 'cursor': 'default' })
				$("#addGroup").attr("disabled", false);
				
				if(data.redirect){
					$(location).attr('href',data.redirect);
				}
			})
			.fail(function(data){
				data=data.responseJSON
				
				if(data.errors.name){
					
					var printError='<div class="alert alert-danger" role="alert">'+data.errors.name+'</div>';
					$('#edit-errors-place').html(printError);
				}
				
				$(document.body).css({ 'cursor': 'default' })
				$("#addGroup").attr("disabled", false);
			});
	}
}