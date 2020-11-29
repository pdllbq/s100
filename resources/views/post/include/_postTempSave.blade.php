<script>
	$( document ).ready(function() {
		setInterval(function(){
			Post.tempPostSave('{{ $titleInputId }}','{{ $groupInputId }}','{{ $textInputId }}');
		},60000);
	});
</script>