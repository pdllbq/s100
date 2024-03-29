@extends('layouts.app')

@section('content')

@include('include._messages')

@if($ban)
	<div class="container">
			<div class="alert alert-danger">{{ __('user.You are banned until :time',['time'=>$ban]) }}</div>
	</div>
@else

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
									<input name="title" maxlength="255" value="{{ old('title',$oldTitle) }}" id="title" type="text" class="form-control" required>
								</div>
								@if($groups->count()>0)
									<div class="form-group">
										<label for="group">{{ __('post.Group') }}</label>
										<select class="form-control" name="group" id="group">
											<option value="{{ NULL }}">Без группы</option>
											@foreach($groups as $group)
											<option value="{{ $group->slug }}" {{ $oldGroup==$group->slug?'selected':'' }}>{{ $group->name }}</option>
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
									 <textarea name="text" id="text" class="form-control" rows="20">{{ old('text',$oldText) }}</textarea>
								</div>
								<div class="form-group">
									<input type="checkbox" id="draft" name="draft">
									<label for="draft"> {{ __('post.Save in draft') }}</label>
								</div>
								@if(\Auth::user()->is_moder==1)
									<div class="form-group">
										<input type="checkbox" id="sandbox" name="sandbox" value="1">
										<label for="sandbox">
											{{ __('moder.Save in sandbox') }}
										</label>
									</div>
								@endif
								@if(\Auth::user()->iframe_allowed==1)
									<div class="form-group">
										<input type="checkbox" id="iframe_mode" name="iframe_mode" value="1">
										<label for="iframe_mode">Iframe</label>
									</div>
									<div id="iframe_input" class="form-group" style="display:none;">
										<label for="iframe_url">Iframe URL</label>
										<input type="text" id="iframe_url" name="iframe_url" value="" class="form-control">
									</div>
								@endif
								@if(\Auth::user()->iframe_allowed==1)
									<div class="form-group">
										<input type="checkbox" id="redirect_mode" name="redirect_mode" value="1">
										<label for="redirect_mode">Redirect</label>
									</div>
									<div id="redirect_input" class="form-group" style="display:none;">
										<label for="redirect_url">Redirect URL</label>
										<input type="text" id="redirect_url" name="redirect_url" value="" class="form-control">
									</div>
								@endif
								<div class="form-group">
									<input id="submit_button" type="submit" value="{{ __('post.Add') }}" class="btn btn-primary">
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
@endif

@include('post.include._postTempSave',['titleInputId'=>'#title','groupInputId'=>'#group','textInputId'=>'#text'])

<script type="text/javascript">

    $(document).ready(function() {


		jQuery('#text').summernote({

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
