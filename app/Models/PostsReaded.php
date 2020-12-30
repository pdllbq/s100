<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class PostsReaded extends Model
{
	protected $table='posts_readed';
	
    function readed($postSlug,$ip,$userName)
	{
		if($userName!=null){
			$count=self::where('slug',$postSlug)->where('user_name',$userName)->count();
		}else{
			$count=0;
		}
		
		if($count==0){
			$count=self::where('slug',$postSlug)->where('ip',$ip)->count();
			
			if($userName!=null){
				self::where('slug',$postSlug)->where('ip',$ip)->update(['user_name'=>$userName]);
			}
		}
		
		if($count==0){
			$this->slug=$postSlug;
			$this->ip=$ip;
			$this->user_name=$userName;
			
			$this->save();
			
			$count=self::where('slug',$postSlug)->count();
			
			Post::where('slug',$postSlug)->update(['showed'=>$count]);
		}
	}
}
