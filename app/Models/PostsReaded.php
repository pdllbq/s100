<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class PostsReaded extends Model
{
	protected $table='posts_readed';
	
    function readed($postSlug,$ip,$userName)
	{
		$count=self::where('ip',$ip)->count();
		
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
