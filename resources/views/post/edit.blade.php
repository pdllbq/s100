@extends('layouts.app')

@section('content')

@include('include._messages')

<form method="POST" action="{{ route('post.update',[app()->getLocale(),$post->slug]) }}">
	@csrf
	@method('PUT')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="card">
					<div class="card-header"> {{ __('post.Edit post') }} </div>
					<div class="card-body">
						<div class="form-group">
							<label for="title">{{ __('post.Title') }}</label>
							<input name="title" maxlength="255" value="{{ old('title',$post->title) }}" id="title" type="text" class="form-control" required>
						</div>
						@if($groups->count()>0)
							<div class="form-group">
								<label for="group">{{ __('post.Group') }}</label>
								<select class="form-control" name="group" id="group">
									<option value="{{ NULL }}">Без группы</option>
									@foreach($groups as $group)
									<option {{ $group->slug==$post->group_slug ? 'selected' : '' }} value="{{ $group->slug }}">{{ $group->name }}</option>
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
							 <textarea name="text" id="text" class="form-control" rows="20">{{ old('text',$post->html) }}</textarea> 
						</div>
						<div class="form-group">
							<input type="submit" value="{{ __('post.Save') }}" class="btn btn-success">
							<a href="{{ url()->previous() }}" class="btn btn-primary">{{ __('post.Cancel') }}</a>
							<a href="{{ route('post.destroy', [app()->getLocale(),$post->slug]) }}" class="btn btn-danger" onclick="return confirm('{{ __('post.Destroy') }}?')">{{ __('post.Destroy') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">

    $(document).ready(function() {

     $('#text').summernote({

           height: 300,
		   
		   fontNames: [],
		   
		   lang: '{{ app()->getLocale() }}',
      });

   });

</script>

@endsection