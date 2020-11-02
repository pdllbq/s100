<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Comment extends Model
{
	function user()
	{
		return $this->belongsTo(User::class);
	}


	function answers()
	{
		return $this->hasMany(Comment::class,'answer_id','id');
	}
	
	static function deleteAllByPostSlug($slug)
	{
		self::where('post_slug',$slug)->delete();
	}
}
