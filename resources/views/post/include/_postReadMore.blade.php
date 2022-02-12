@foreach($nextPosts as $post)
<?php
$img='/img/no-image.jpg';

$files=explode(',',$post->files);

foreach($files as $file){
    $ext=explode('.',$file);
    $ext=end($ext);
    if($ext=='jpg' || $ext=='jpeg' || $ext=='gif' || $ext=='png'){
	$img=Storage::url($file);
	break;
    }
}

//$img=substr($img,6);
?>


<?php
if($post->group_slug!=null){
	$groupSlugOrUserName=$post->group_slug;
}else{
	$groupSlugOrUserName='@'.$post->user_name;
}
?>


<div class="col-12 col-lg-4 read-more-posts" onClick="location.href='{{route('post.show',[app()->getLocale(),$groupSlugOrUserName,$post->slug])}}'">
    <div class="read-more-img float-left">
	<img src="{{$img}}">
    </div>
    <div class="read-more-text-content overflow-hidden">
	<div class="read-more-title text-truncate h5">
	    {{ $post->title }}
	</div>
	<div class="read-more-excerpt">
	    {{ $post->excerpt_no_html }}
	</div>
    </div>
</div>

@endForeach