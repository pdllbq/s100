<?php
$tags=explode(',',$tags);
?>

@foreach($tags as $tag)

<a href="{{ route('post.tag',[app()->getLocale(),str_replace('#','',$tag)]) }}">{{ $tag }}</a>

@endforeach