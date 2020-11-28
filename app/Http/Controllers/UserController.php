<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\User;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;
use Carbon\Carbon;

class UserController extends Controller
{
    function show($locale,$userName)
	{
		$user=User::where('name',$userName)->first();
		
		if(!isset($user->id)){
			return redirect('/'.\app()->getLocale().'/404');
		}
		
		$ban=User::isBanned($userName);
		
		$title='@'.$user->name;
		
		$posts=Post::where('user_id',$user->id)->where('draft',0)->orderBy('id','DESC')->with(['user','voted'])->paginate(100);
		if(isset(\Auth::user()->id)){
			$subscribed=Subscribe::where('master_id',\Auth::user()->id)->where('slave_id',$user->id)->count();
		}else{
			$subscribed=0;
		}
		
		$userGroups=Group::where('user_id',$user->id)->get();
		
		$subscribers=Subscribe::where('master_id',$user->id)->count();
		
		return view('user.show',['user'=>$user,'posts'=>$posts,'subscribed'=>$subscribed,'subscribers'=>$subscribers,'userGroups'=>$userGroups,'title'=>$title,'ban'=>$ban]);
	}
	
	function profile()
	{
		$user=User::where('id',\Auth::user()->id)->first();
		
		$userGroups=Group::where('user_id',$user->id)->get();
		
		return view('user.profile',['user'=>$user,'userGroups'=>$userGroups]);
	}
	
	function profileSave(\App\Http\Requests\StoreUserRequest $request)
	{
		$inputs=$request->input();
		
		if($inputs['password']!='' && $inputs['password2']!=''){
			if($inputs['password']==$inputs['password2']){
				$hash=\Hash::make($inputs['password']);
				$user=User::where('id',\Auth::user()->id)->first();
				
				$user->password=$hash;
				$user->save();
				
				return redirect()->route('user.profile',app()->getLocale())->withSuccess(__('user.Password was updated'));
			}else{
				return redirect()->route('user.profile',app()->getLocale())->withErrors(['message1'=>__('user.Passwords do not match')]);
			}
		}
		
		return redirect()->route('user.profile',app()->getLocale());
	}
	
	function uploadAvatar(\App\Http\Requests\StoreAvatarRequest $request)
	{
		$avatar=\Auth::user()->avatar;
		$avatar=str_replace('/storage/','public/',$avatar);
		//dd($avatar);
		Storage::delete($avatar);
		
		$file=$request->file('avatar');
		$exst=$file->getClientOriginalExtension();
		
		$fileName='public/avatars/'.\Auth::user()->id.'.'.$exst;
		
		$url=Storage::put($fileName,$file,'public');
		
		$url=Storage::url($url);
		
		User::where('id',\Auth::user()->id)->update(['avatar'=>$url]);
		
		return redirect()->route('user.profile',app()->getLocale());
	}
	
	function setLang($lang)
	{
		
		if($lang=='ru' || $lang=='lv' || $lang=='en'){
			if(isset(\Auth::user()->id)){
				User::where('id',\Auth::user()->id)->update(['lang'=>$lang]);
			}
		}
		
		return redirect('/'.$lang);
	}
	
	function deleteMe()
	{
		
	}
	
	function ban($locale,$userName,$time)
	{
		if(\Auth::user()->is_moder!=1){
			return redirect()->route('user.show',[App()->getLocale(),$userName]);
		}
		
		if($time=='day'){
			$time=Carbon::now()->addDay();
			User::where('name',$userName)->update(['ban_until'=>$time]);
		}
		if($time=='week'){
			$time=Carbon::now()->addWeek();
			User::where('name',$userName)->update(['ban_until'=>$time]);
		}
		if($time=='month'){
			$time=Carbon::now()->addMonth();
			User::where('name',$userName)->update(['ban_until'=>$time]);
		}
		if($time=='year'){
			$time=Carbon::now()->addYear();
			User::where('name',$userName)->update(['ban_until'=>$time]);
		}
		if($time=='2038'){
			$time='2038-01-01 00:00:00';
			User::where('name',$userName)->update(['ban_until'=>$time]);
		}
		
		return redirect()->route('user.show',[App()->getLocale(),$userName]);
	}
	
	function unban($locale,$userName)
	{
		if(\Auth::user()->is_moder!=1){
			return redirect()->route('user.show',[App()->getLocale(),$userName]);
		}
		
		$time=Carbon::now()->toDateTimeString();
		User::where('name',$userName)->update(['ban_until'=>$time]);

		return redirect()->route('user.show',[App()->getLocale(),$userName]);
	}
}
