class Post
{
	static tempPostSave(titleInputId,groupInputId,textInputId)
	{
		var title=$(titleInputId).val();
		var group=$(groupInputId).val();
		var text=$(textInputId).val();
		
		$.post('/post/tempSave',{title:title,group:group,text:text});
	}
}