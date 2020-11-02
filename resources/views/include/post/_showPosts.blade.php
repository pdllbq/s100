@if($posts->count()==0)
	<div class="alert alert-primary text-center">{{ __('post.No posts') }}</div>
@endif

@foreach($posts as $post)
<small class="post-info"><a href="{{route('user.show',[app()->getLocale(),$post->user->name]) }}">&commat;{{ $post->user->name }}</a> {!! $post->group_slug!=false ? '&gt; <a href="'.route('group.show',[app()->getLocale(),$post->group_slug]).'">'.$post->group->name.'</a>':'' !!} | {{ $post->created_at->diffForHumans() }} <br></small>
<h2 class="post-title"><a href="{{ route('post.show',[app()->getLocale(),$post->slug]) }}">{{ $post->title }}</a></h2>
<div class="post-content">
	@if(\Route::currentRouteName()!='post.show' && $post->excerpt!=NULL)
		{!! $post->excerpt !!}
		@if($post->excerpt!=$post->html)
			<div class="read-more"><a class=" btn btn-outline-primary btn-sm" href="{{ route('post.show',[app()->getLocale(),$post->slug]) }}">{{ __('post.Read more') }}</a></div>
		@endif
	@else
	{!! $post->html !!}
	@endif

	<div style="clear:both;"></div>
	
</div>

@if(isset($post->voted[0]))
	<?php
		if($post->voted[0]->type=='+'){
			$plusActive='plus-active';
		}elseif($post->voted[0]->type=='-'){
			$minusActive='minus-active';
		}
	?>
@endif
<br>
<span class="post-footer">
	<span onClick="ratingPlus('{{ $post->slug }}','{{ app()->getLocale() }}')" id="button-plus-{{ $post->slug }}" class="rating-button-plus fa {{ $plusActive ?? ''}}">&#xf087;</span> <span id="rating_{{ $post->slug }}">{{ $post->rating }}</span> 
	<span onClick="ratingMinus('{{ $post->slug }}','{{ app()->getLocale() }}')" id="button-minus-{{ $post->slug }}" class="rating-button-minus fa {{ $minusActive ?? '' }}">&#xf088;</span> |
	<a href="{{ route('post.show',[app()->getLocale(),$post->slug,'#comments']) }}"><span class="fa">&#xf086; {{ $post->comments_count }}</span></a>
</span>
<br><br>
<?php
	unset($plusActive);
	unset($minusActive);
?>
@endforeach