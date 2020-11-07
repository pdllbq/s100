@extends('layouts.app')

@section('content')

@include('include._messages')

@if($canCreate==1)
	<form method="POST" action="{{ route('post.store',app()->getLocale()) }}">
		@csrf
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12">
					<div class="card">
						<div class="card-header"> {{ __('post.Add post') }} </div>
						<div class="card-body">
							<div class="form-group">
								<label for="title">{{ __('post.Title') }}</label>
								<input name="title" maxlength="255" value="{{ old('title') }}" id="title" type="text" class="form-control" required>
							</div>
							@if($groups->count()>0)
								<div class="form-group">
									<label for="group">{{ __('post.Group') }}</label>
									<select class="form-control" name="group" id="group">
										<option value="{{ NULL }}">Без группы</option>
										@foreach($groups as $group)
											<option value="{{ $group->slug }}">{{ $group->name }}</option>
										@endforeach
									</select>
								</div>
							@else
								<input type="hidden" name="group" id="group" value="{{ NULL }}">
							@endif
							<div class="form-group">
								<label for="text">{{ __('post.Text') }}</label>
	<!--							<input id="article-text-new-model" type="hidden" name="text" value="{{ old('text') }}">
								@trix(\App\Article::class, 'text')-->
								 <textarea name="text" id="text" class="form-control" rows="20">{{ old('text') }}</textarea> 
							</div>
							<div class="form-group">
								<input type="submit" value="{{ __('post.Add') }}" class="btn btn-primary">
								<a href="{{ url()->previous() }}" class="btn btn-danger">{{ __('post.Cancel') }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@else
	<div class="container">
		<div class="alert alert-danger">{{ __('post.Next post you can create in :time',['time'=>$nextPost]) }}</div>
	</div>
@endif

<script type="text/javascript">

    $(document).ready(function() {

		$('#text').summernote({
			
			callbacks: {
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					document.execCommand('insertText', false, bufferText);
				}
			},

			height: 300,

			fontNames: [],

			lang: '{{ app()->getLocale() }}',
		 });

   });

</script>

@endsection