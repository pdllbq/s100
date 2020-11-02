<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    static function newAnswerOnComment($userId,$postSlug,$commentId)
	{
		$Notification=new Notification;
		
		$Notification->user_id=$userId;
		$Notification->post_slug=$postSlug;
		$Notification->text='notification.New answer on comment';
		$Notification->comment_id=$commentId;
		$Notification->save();
	}
}
