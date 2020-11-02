<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\User;

class Rating extends Model
{
    public function plus($postSlug,$userId)
	{
		$count=self::where('post_slug',$postSlug)->where('user_id',$userId)->where('type','+')->count();
		
		self::where('post_slug',$postSlug)->where('user_id',$userId)->delete();
	
		if($count==0){
			$this->post_slug=$postSlug;
			$this->user_id=$userId;
			$this->type='+';
			$this->save();
		}
	}
	
	public function minus($postSlug,$userId)
	{
		$count=self::where('post_slug',$postSlug)->where('user_id',$userId)->where('type','-')->count();
		
		self::where('post_slug',$postSlug)->where('user_id',$userId)->delete();
	
		if($count==0){
			$this->post_slug=$postSlug;
			$this->user_id=$userId;
			$this->type='-';
			$this->save();
		}
	}
	
	public function getRating($postSlug)
	{
		$pluses=self::where('post_slug',$postSlug)->where('type','+')->count();
		$minuses=self::where('post_slug',$postSlug)->where('type','-')->count();
		
		$rating=$pluses-$minuses;
		
		$post=Post::where('slug',$postSlug)->first();
		
		if(strtotime($post->created_at)>=strtotime('-24 hours')){
			$user=User::where('id',$post->user_id)->first();
			
			$rating24h=$rating+$user->rating;
		}else{
			$rating24h=$rating;
		}
		
		$userRating=Post::where('user_id',$post->user_id)->sum('rating');
		
		Post::where('slug',$postSlug)->update(['rating'=>$rating,'24h_rating'=>$rating24h]);
		User::where('id',$post->user_id)->update(['rating'=>$userRating]);
		
		return $rating;
	}
	
	
	//Удалить рейтинг записи
	function deleteRating($slug)
	{
		self::where('post_slug',$slug)->delete();
	}
}
