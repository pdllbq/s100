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
		$messages=Message::where('to_name',\Auth::user()->name)->orderBy('id','DESC')->get();
		
		return view('message.index', compact('messages'));
	}
	
    function create($locale,$userName)
	{
		return view('message.create', compact('userName'));
	}
	
	function store(Request $request)
	{
		$inputs=$request->input();
		
		$u=str_replace('@','',$inputs['user_name']);
		$userExists=User::where('name',$u)->count();
		
		if($userExists>0){
			$Message=new Message;

			$Message->from_name=\Auth::user()->name;
			$Message->to_name=$u;
			$Message->message=$inputs['message'];
			$Message->save();
		}
		
		return view('message.store', compact('userExists'));
	}
	
	function show($locale,$id)
	{
		$message=Message::where('id',$id)->where('to_name',\Auth::user()->name)->first();
		
		Message::where('id',$id)->where('to_name',\Auth::user()->name)->update(['readed'=>1]);
		
		return view('message.show',compact('message'));
	}
	
	function delete($locale,$id)
	{
		$Message=new Message;
		
		if($id=='*'){
			$Message->where('to_name',\Auth::user()->name)->delete();
		}else{
			$Message->where('id',$id)->where('to_name',\Auth::user()->name)->delete();
		}
	}
}
