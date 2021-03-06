<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model
{
	//protected $fillable = ['email','subject','message'];
	
    function newNotification($email,$subject,$message)
	{
		$count=$this->where('email',$email)->where('subject',$subject)->where('message',$message)->count();

		if($count==0){
			$this->email=$email;
			$this->subject=$subject;
			$this->message=$message;
			$this->save();
		}
	}
}
