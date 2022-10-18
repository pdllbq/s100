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
							<input type="checkbox" id="draft" name="draft" value="on" {{ $post->draft==1?'checked="checked"':'' }}>
							<label for="draft"> {{ __('post.Save in draft') }}</label>
						</div>
						@if(\Auth::user()->is_moder==1)
							<div class="form-group">
								<input type="checkbox" id="sandbox" name="sandbox" value="1" {{ $post->in_sandbox==1?'checked="checked"':'' }}>
								<label for="sandbox">
									{{ __('moder.Save in sandbox') }}
								</label>
							</div>
						@endif
						@if(\Auth::user()->iframe_allowed==1)
							<div class="form-group">
								<input type="checkbox" id="iframe_mode" name="iframe_mode" value="1" {{ $post->iframe_mode==1?'checked="checked"':'' }}>
								<label for="iframe_mode">Iframe</label>
							</div>
							<div id="iframe_input" class="form-group" {{ $post->iframe_mode==0?'style=display:none;':'style=display:block;' }}>
								<label for="iframe_url">Iframe URL</label>
								<input type="text" id="iframe_url" name="iframe_url" value="{{ old('iframe_url',$post->iframe_url) }}" class="form-control">
							</div>
						@endif

						@if(\Auth::user()->iframe_allowed==1)
							<div class="form-group">
								<input type="checkbox" id="redirect_mode" name="redirect_mode" value="1" {{ $post->redirect_mode==1?'checked="checked"':'' }}>
								<label for="redirect_mode">Redirect</label>
							</div>
							<div id="redirect_input" class="form-group" {{ $post->redirect_mode==0?'style=display:none;':'style=display:block;' }}>
								<label for="redirect_url">Redirect URL</label>
								<input type="text" id="redirect_url" name="redirect_url" value="{{ old('redirect_url',$post->redirect_url) }}" class="form-control">
							</div>
						@endif

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

			styleTags: ['p','h1', 'h2', 'h3', 'h4', 'h5', 'h6'],

			toolbar: [
				['style', ['style']],
				['font', ['bold','underline','strikethrough', 'clear']],
				['insert', ['link', 'picture', 'video','telegram','tiktok']],
				['view', ['fullscreen', 'codeview']],
			],

			buttons: {
				telegram: telegramButton,
				tiktok: tiktokButton
			},

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

    $(document).ready(function() {

     $('#text').summernote({

           height: 300,

		   fontNames: [],

		   lang: '{{ app()->getLocale() }}',
      });

   });


   $(document).ready(function() {
		$("#iframe_mode").click(function(event) {
		  if ($(this).is(":checked"))
			$("#iframe_input").show('fast');
		  else
			$("#iframe_input").hide('fast');
		});

		$("#redirect_mode").click(function(event) {
		  if ($(this).is(":checked"))
			$("#redirect_input").show('fast');
		  else
			$("#redirect_input").hide('fast');
		});
	});
</script>

@endsection
