<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTempSave extends Model
{
    function store($userName,$title,$group,$text)
	{
		$this->where('user_name',$userName)->delete();
		
		$this->user_name=$userName;
		$this->title=$title;
		$this->group_slug=$group;
		$this->text=$text;
		
		$this->save();
	}
}
