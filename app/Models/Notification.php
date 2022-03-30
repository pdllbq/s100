<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    static function newAnswerOnComment($userId,$groupSlugOrUserName,$postSlug,$commentId)
	{
		$Notification=new Notification;

		$Notification->user_id=$userId;
		$Notification->group_slug_or_user_name = $groupSlugOrUserName;
		$Notification->post_slug=$postSlug;
		$Notification->text='notification.New answer on comment';
		$Notification->comment_id=$commentId;
		$Notification->save();
	}
}
