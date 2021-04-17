<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\User;

class MessageController extends Controller
{
//	public function __construct() {
//		if(!isset(\Auth::user()->id)){
//			redirect('home');
//		}
//	}
	
	function index()
	{
		$messages=Message::getChats(\Auth::user()->name);
		
		//dd($messages);
		
		return view('message.index', compact('messages'));
	}
	
    function create($locale,$userName)
	{
		$ban=User::isBanned(\Auth::user()->name);
		
		return view('message.create', compact('userName','ban'));
	}
	
	function store(Request $request)
	{
		$ban=User::isBanned(\Auth::user()->name);
		
		$inputs=$request->input();
		
		$u=str_replace('@','',$inputs['user_name']);
		$userExists=User::where('name',$u)->count();
		
		if($userExists>0 && !$ban){
			Message::sendNewMessage(\Auth::user()->name,$u,$inputs['message']);
		}
		
		return view('message.store', compact('userExists','ban','u'));
	}
	
	function show($locale,$userName)
	{
		$messages=Message::where('owner_name',\Auth::user()->name)
				->where(function($query) use ($userName){
					$query->where('to_name',$userName)->orWhere('from_name',$userName);
				})
				->get();
		
		Message::where('owner_name',\Auth::user()->name)->where('to_name',\Auth::user()->name)->update(['readed'=>1]);
		
		return view('message.show',compact('messages','userName'));
	}
	
	function delete($locale,$name)
	{
		$Message=new Message;
		
		if($name=='*'){
			$Message->where('owner_name',\Auth::user()->name)->delete();
		}else{
			$Message->where('to_name',$name)->where('owner_name',\Auth::user()->name)->delete();
			$Message->where('to_name',\Auth::user()->name)->where('from_name',$name)->where('owner_name',\Auth::user()->name)->delete();
		}
	}
}
