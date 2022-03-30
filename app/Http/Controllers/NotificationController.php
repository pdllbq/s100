<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Post;

class NotificationController extends Controller
{
	function index(){

		if(isset(\Auth::user()->id)){
			$notifications=Notification::where('user_id',\Auth::user()->id)->orderBy('id','DESC')->get();
		}else{
			$notifications=null;
		}

		return view('notification.index', compact('notifications'));
	}

	function clear()
	{
		Notification::where('user_id',\Auth::user()->id)->delete();

		return 'Ok';
	}
}
