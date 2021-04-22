<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\User;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;
use Carbon\Carbon;
use App\Models\BanIp;
use App\Models\Withdrawl;
use App\Models\EmailNotification;

class UserController extends Controller
{
    function show($locale,$userName)
	{
		$user=User::where('name',$userName)->first();
		
		if(!isset($user->id)){
			return redirect('/'.\app()->getLocale().'/404');
		}
		
		$ban=User::isBanned($userName);
		$banIp=BanIp::isBanned($user->ip);
		
		$title='@'.$user->name;
		
		$posts=Post::where('user_id',$user->id)->where('draft',0)->orderBy('id','DESC')->with(['user','voted'])->paginate(100);
		if(isset(\Auth::user()->id)){
			$subscribed=Subscribe::where('master_id',\Auth::user()->id)->where('slave_id',$user->id)->count();
		}else{
			$subscribed=0;
		}
		
		$userGroups=Group::where('user_id',$user->id)->get();
		
		$subscribers=Subscribe::where('master_id',$user->id)->count();
		
		return view('user.show',['user'=>$user,'posts'=>$posts,'subscribed'=>$subscribed,'subscribers'=>$subscribers,'userGroups'=>$userGroups,'title'=>$title,'ban'=>$ban,'banIp'=>$banIp]);
	}
	
	function profile()
	{
		if(!isset(\Auth::user()->id)){
			return redirect()->route('login',[App()->getLocale()]);
		}
		
		$user=User::where('id',\Auth::user()->id)->first();
		
		$userGroups=Group::where('user_id',$user->id)->get();
		
		$referralCount=User::where('referral',\Auth::user()->name)->count();
		
		return view('user.profile',['user'=>$user,'userGroups'=>$userGroups,'referralCount'=>$referralCount]);
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
	
	function banIp($locale,$ip)
	{		
		if(\Auth::user()->is_moder!=1){
			return redirect()->back();
		}
		
		$BanIp=new BanIp;
		
		$BanIp->ip=$ip;
		$BanIp->save();
		
		return redirect()->back();
	}
	
	function unbanIp($locale,$ip)
	{		
		if(\Auth::user()->is_moder!=1){
			return redirect()->back();
		}
		
		BanIp::where('ip',$ip)->delete();
		
		return redirect()->back();
	}
	
	function withdrawl()
	{	
		$balance=\Auth::user()->balance;
		
		$data['title']=__('user.Withdrawl');
		
		$data['body']=view('user.include._withdrawlModalBody',compact(['balance']))->render();
		
		$data['footer']=view('user.include._withdrawlModalFooter')->render();
		
		return json_encode($data);
	}
	
	function withdrawlSave(Request $request)
	{
		$amount=abs($request->input('amount'));
		$fullName=$request->input('full_name');
		$bankAccountNumber=$request->input('bank_account_number');
		$ethWallet=$request->input('eth_wallet');
		$otherInfo=$request->input('other_info');
		
		$bank=$request->input('bank');
		$eth=$request->input('eth');
		$other=$request->input('other');
		
		if($amount>\Auth::user()->balance){
			$data['error']=__('user.Insufficient balance');
		}elseif($amount>=1){
			$data['success']=__('user.Withdrawal request successful');
			
			$Withdrawl=new Withdrawl;
			$Withdrawl->user_name=\Auth::user()->name;
			$Withdrawl->amount=$amount;
			$Withdrawl->full_name=$fullName;
			$Withdrawl->bank_account_number=$bankAccountNumber;
			$Withdrawl->eth_wallet=$ethWallet;
			$Withdrawl->other_info=$otherInfo;
			$Withdrawl->bank=$bank;
			$Withdrawl->eth=$eth;
			$Withdrawl->other=$other;
			$Withdrawl->save();
			
			User::where('id',\Auth::user()->id)->update(['balance'=>\DB::raw('balance-'.$amount)]);
			
			$EmailNotification=new EmailNotification;
			$email=env('ADMIN_EMAIL');
			$subject=__('emailNotifications.Request to withdrawl subject');
			$message=__('emailNotifications.Request to withdrawl message :url',['url'=>'https://s100.lv/ru/user/withdrawl_moderation']);
			$EmailNotification->newNotification($email,$subject,$message);
			
		}elseif($amount<1){
			$data['error']=__('user.Minimum withdrawal amount €1');
		}
		
		return json_encode($data);
	}
	
	function withdrawlModeration()
	{
		if(\Auth::user()->is_admin!=1){
			return redirect('/404');
		}
		
		$data=Withdrawl::where('processed',0)->get();
		
		return view('user.withdrawlModeration',compact('data'));
	}
	
	function withdrawlWithdrawed($locale,$id)
	{
		if(\Auth::user()->is_admin!=1){
			return redirect('/404');
		}
		
		Withdrawl::where('id',$id)->update(['processed'=>1]);
		
		return redirect()->back();
	}
	
	function withdrawlReturnToBalance($locale,$id)
	{
		if(\Auth::user()->is_admin!=1){
			return redirect('/404');
		}
		
		$data=Withdrawl::where('id',$id)->first();
		
		if(!isset($data['user_name'])){
			return redirect()->back();
		}
		
		User::where('name',$data['user_name'])->update(['balance'=>\DB::raw('balance+'.$data['amount'])]);
		
		Withdrawl::where('id',$data['id'])->delete();
		
		return redirect()->back();
	}
	
	function showReferrals()
	{
		
		$referrals=User::where('referral',\Auth::user()->name)->get();
		
		$data['title']=__('user.My referrals');
		
		$data['body']=view('user.include._showReferrals',compact('referrals'))->render();
		
		$data['footer']=view('user.include._referralsModalFooter')->render();
		
		return json_encode($data);
	}
}
