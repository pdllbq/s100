<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use App\User;

class SubscribeController extends Controller
{
    function user($locale,$slaveId)
	{
		$Subscribe=new Subscribe;
		
		$Subscribe->user(\Auth::user()->id,$slaveId);
		
		$count=Subscribe::where('slave_id',$slaveId)->count();
		
		User::where('id',$slaveId)->update(['subscribers'=>$count]);
		
		return 'Ok';
	}
	
	function tag($locale,$tag)
	{
		$Subscribe=new Subscribe;
		
		$Subscribe->tag(\Auth::user()->id,'#'.$tag);
		
		return 'Ok';
	}
	
	function group($locale,$groupSlug)
	{
		$Subscribe=new Subscribe;
		
		$Subscribe->group(\Auth::user()->id,$groupSlug);
		
		return 'Ok';
	}
}
