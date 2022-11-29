<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
	use SoftDeletes;
	
    function user()
	{
		return $this->belongsTo(User::class);
	}
	
	function group()
	{
		return $this->belongsTo(Group::class,'group_slug','slug');
	}
	
	public function referral()
	{ 
		return $this->belongsTo(User::class,'user_id','id');
	}
	
	function voted()
	{
		if(!isset(\Auth()->user()->id)){
			$userId=0;
		}else{
			$userId=\Auth()->user()->id;
		}
		
		return $this->hasMany(Rating::class,'post_slug','slug')->where('user_id',$userId);
	}
	
	function comments()
	{
		return $this->hasMany(Comment::class,'post_slug','slug');
	}
	
	static function deleteByGroupSlug($slug)
	{
		$posts=self::where('group_slug',$slug);
		
		$postsData=$posts->get();
		
		foreach($postsData as $data){
			Comment::deleteAllByPostSlug($data->slug);
		}
		
		$posts->delete();
	}

	//Get post image
	public function getPostImage()
	{
		$img=explode(',',$this->files);

		if(isset($img[0])){
			return $img[0];
		}

		return null;
	}

}
