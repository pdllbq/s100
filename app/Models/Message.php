<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	static function getAvatar($userName)
	{
		$user=User::select('avatar')->where('name',$userName)->first();
		return $user->avatar;
	}
	
	static function getChats($userName)
	{
		$messages=self::where('owner_name',$userName)->orderBy('readed','ASC')->orderBy('id','DESC')->get();
		
		$chats=[];
		
		foreach($messages as $data){
			if($data['to_name']==$userName){
				if(!isset($chats[$data['from_name']])){
					$chats[$data['from_name']]['all']=1;
					$chats[$data['from_name']]['data']=$data;
					if($data['readed']==0){
						$chats[$data['from_name']]['new']=1;
					}else{
						$chats[$data['from_name']]['new']=0;
					}
				}else{
					$chats[$data['from_name']]['all']++;
					if($data['readed']==0){
						$chats[$data['from_name']]['new']++;
					}
				}
			}elseif($data['from_name']==$userName){
				if(!isset($chats[$data['to_name']])){
					$chats[$data['to_name']]['all']=1;
					$data->user['avatar']=self::getAvatar($data['to_name']);
					$chats[$data['to_name']]['data']=$data;
					if($data['readed']==0){
						$chats[$data['to_name']]['new']=0;
					}else{
						$chats[$data['to_name']]['new']=0;
					}
				}else{
					$chats[$data['to_name']]['all']++;
					if($data['readed']==0){
						//$chats[$data['to_name']]['new']++;
					}
				}
			}
		}
		
		return $chats;
	}
	
	static function sendNewMessage($userNameFrom,$userNameTo,$message)
	{
		$Message=new Message;
		
		$Message->owner_name=$userNameFrom;
		$Message->from_name=$userNameFrom;
		$Message->to_name=$userNameTo;
		$Message->message=$message;
		$Message->save();
		
		$Message=new Message;
		$Message->owner_name=$userNameTo;
		$Message->from_name=$userNameFrom;
		$Message->to_name=$userNameTo;
		$Message->message=$message;
		$Message->save();
	}
	
    function user()
	{
		return $this->belongsTo(User::class,'from_name','name');
	}
}
