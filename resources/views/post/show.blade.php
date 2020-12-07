@extends('layouts.app')

@section('title',$post->title)

@section('description',$post->excerpt_no_html)

@section('keywords',str_replace('#','',$post->tags))

@section('content')

@include('include._messages')

<div class="container">
	<div class="row">
		<div class="col-12">
			
			@if(isset($post->voted[0]))
				<?php
					if($post->voted[0]->type=='+'){
						$plusActive='plus-active';
					}elseif($post->voted[0]->type=='-'){
						$minusActive='minus-active';
					}
				?>
			@endif
			
			<small class="post-info"><a href="{{route('user.show',[app()->getLocale(),$post->user->name]) }}">&commat;{{ $post->user->name }}</a> {!! $post->group_slug!=false ? '&gt; <a href="'.route('group.show',[app()->getLocale(),$post->group_slug]).'">'.$post->group->name.'</a>':'' !!} | {{ $post->date }} <br></small>

			<h1 class="post-title">{{ $post->title }}</h1>
				
			<div class="post-content">
				@if($post->iframe_mode==1)
					<div class="iframe-responsive"><iframe src="{{ $post->iframe_url }}"></iframe></div>
				@else
					{!! $post->html !!}
				@endif

				<div style="clear:both;"></div>

			</div>
			<div class="post-footer">
				<span onClick="ratingPlus('{{ $post->slug }}','{{ app()->getLocale() }}')" id="button-plus-{{ $post->slug }}" class="rating-button-plus fa {{ $plusActive ?? ''}}">&#xf087;</span> <span id="rating_{{ $post->slug }}">{{ $post->rating }}</span> 
				<span onClick="ratingMinus('{{ $post->slug }}','{{ app()->getLocale() }}')" id="button-minus-{{ $post->slug }}" class="rating-button-minus fa {{ $minusActive ?? '' }}">&#xf088;</span>

				@if($post->user_id==Auth::id())
				| <a href="{{ route('post.edit',[app()->getLocale(),$post->slug]) }}">{{ __('post.Edit') }}</a> | <a href="{{ route('post.destroy', [app()->getLocale(),$post->slug]) }}" onclick="return confirm('{{ __('post.Destroy') }}?')">{{ __('post.Destroy') }}</a>
				@endif
			</div>
			
			
		</div>
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-12">
			<h2>{{ __('post.Comments') }} ({{ $post->comments_count }})</h2>
		</div>
		
		@guest
			<div class="col-12">
				<div class="alert alert-primary">{{ __('post.Auth to write comment') }}</div>
			</div>
		@elseif(!$ban)
			<div class="col-12">
				<form method="POST" action="{{ route('post.addComment',app()->getLocale()) }}">
					@csrf
					<div class="form-group">
						<textarea name="comment" id="comment" class="form-control" placeholder="{{ __('post.Add comment') }}">{{ old('comment') }}</textarea>
					</div>
					<input type="hidden" name="post-slug" value="{{ $post->slug }}">
					<input type="hidden" name="answer-id" value="0">
					<div class="form-group">
						<input type="submit" value="{{ __('post.Add') }}" class="btn btn-primary">
					</div>
				</form>
			</div>
		@else
			<div class="container">
					<div class="alert alert-danger">{{ __('user.You are banned until :time',['time'=>$ban]) }}</div>
			</div>
		@endguest
		
		<div class="col-12">
			@foreach($comments as $comment)
			<div class="card">
				<div class="card-body">
					<a id="comment-{{ $comment->id }}"  name="comment-{{ $comment->id }}"></a>
					<small class="post-info"><a href="{{route('user.show',[app()->getLocale(),$comment->user->name]) }}">&commat;{{ $post->user->name }}</a> | {{ $comment->created_at->diffForHumans() }} <br></small>
					{{ $comment->text }}
					@auth
						<div><small class="post-info"><span id="commentModal" class="btn-link" style="cursor:pointer;" data-toggle="modal" data-target="#commentAnswerModal" data-commentid="{{ $comment->id }}">{{ __('post.Make answer') }}</span></small></div>
					@endauth
					<div id="commentData{{ $comment->id }}"></div>
					<script>
						$(function(){
							Comments.getAnswers('{{ route('post.getAnswers',[app()->getLocale(),$comment->id]) }}','commentData{{ $comment->id }}')
						});
					</script>
				</div>
			</div>
			<br>
			@endforeach
		</div>
	</div>
</div>

@include('post.include._commentAnswer',['ban'=>$ban])

<script>
	$('#commentAnswerModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var commentId = button.data('commentid') // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		modal.find('#answer-id').val(commentId)
		modal.find('#post-slug').val('{{ $post->slug }}')
	})
</script>

@endsection