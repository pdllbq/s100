@if($posts->count()==0)
	<div class="alert alert-primary text-center">{{ __('post.No posts') }}</div>
@endif

@foreach($posts as $post)
<small class="post-info"><a href="{{route('user.show',[app()->getLocale(),$post->user->name]) }}">&commat;{{ $post->user->name }}</a> {!! $post->group_slug!=false ? '&gt; <a href="'.route('group.show',[app()->getLocale(),$post->group_slug]).'">'.$post->group->name.'</a>':'' !!} | {{ $post->created_at->diffForHumans() }} <br></small>
<h2 class="post-title"><a href="{{ route('post.show',[app()->getLocale(),$post->slug]) }}">{{ $post->title }}</a></h2>
<div class="post-content">
	@if(\Route::currentRouteName()!='post.show' && $post->excerpt!=NULL)
		{!! $post->excerpt !!}
		@if($post->excerpt!=$post->html || $post->iframe_mode!=0)
		<div class="read-more"><a class=" btn btn-outline-primary btn-sm" href="{{ route('post.show',[app()->getLocale(),$post->slug]) }}">{{ __('post.Read more') }}</a></div>
		@endif
		@if($post->iframe_mode!=0)
		<a target="_blank" style="display: inline-block;" class=" btn btn-outline-primary btn-sm" href="{{ $post->iframe_url }}">{{ __('post.Read more on :site',['site'=>parse_url($post->iframe_url,PHP_URL_HOST)]) }}</a>
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
	<i class="fa fa-eye">{{ $post->showed }}</i> |
	<i class="fa fa-euro" title="{{ __('post.Earned €:count',['count'=>$post->earned]) }}">{{ round($post->earned,2) }}</i> |
	<a href="{{ route('post.show',[app()->getLocale(),$post->slug,'#comments']) }}"><span class="fa">&#xf086; {{ $post->comments_count }}</span></a>
</span>
<br><br>
<?php
	unset($plusActive);
	unset($minusActive);
?>
@endforeach