<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostImages extends Model
{
    static function add($postSlug,$fileName)
	{
		$count=self::where('post_slug',$postSlug)->where('file_name',$fileName)->count();
		
		if($count==0){
			$PostImages=new PostImages;
			
			$PostImage->post_slug=$postSlug;
			$PostImage->file_name=$fileName;
			$PostImage->save();
		}
	}
}
