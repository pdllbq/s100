<div class="container-fluid">
	<div class="row">
		<div class="col-12"></div>
			@foreach($notifications as $data)
				<div class="list-group list-group-flush">
					<a href="{{ __route('post',[app()->getLocale(),$data->post_slug]) }}" class="list-group-item"></a>
				</div>
			@endforeach
		</div>
	</div>
</div>