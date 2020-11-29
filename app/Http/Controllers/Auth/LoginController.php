<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {	
        $this->middleware('guest')->except('logout');
    }
	
	function authenticated()
	{
		User::where('id',\Auth::user()->id)->update(['ip'=>\Request::ip()]);
	}
	
	function handleFacebookCallback()
	{
		if($_SERVER['SERVER_NAME']=='localhost'){
			return redirect('http://s100.loc/login/facebook/callback?code='.$_GET['code'].'&state='.$_GET['state']);
		}

		$user = Socialite::driver('facebook')->user();
		
		
		return $this->facebookAuth($user);
		// $user->token;
		
	}
	
	function redirectToFacebook()
	{
		Cookie::queue('locale',\app()->getLocale(),5);
		return Socialite::driver('facebook')->redirect();
	}
	
	function facebookAuth($facebookUser){
		
		$user=User::where('facebook_id',$facebookUser->id)->first();
		
		if(!isset($user->id)){
			if(isset($facebookUser->nickname) && $facebookUser->nickname!=null){
				$name=$facebookUser->nickname;
			}else{
				$name=$facebookUser->name;
			}
			
			if($this->checkEmail($facebookUser->email)){
				\app()->setLocale(Cookie::get('locale'));
				return redirect()->route('login',Cookie::get('locale'))->withErrors([__('auth.E-mail alredy exists')]);
			}
			
			$User=new User;
			$User->name=$this->newNickname($name);
			$User->facebook_id=$facebookUser->id;
			$User->email=$facebookUser->email;
			$User->avatar=$this->facebookAvatar($facebookUser->avatar_original,$facebookUser->id);
			$User->password=Hash::make(Str::random(12));
			$User->save();
			
			$this->facebookAuth($facebookUser);
		}else{
			\Auth::loginUsingId($user->id,true);
			User::where('id',$user->id)->update(['ip'=>\Request::ip()]);
		}
		return redirect('/'.Cookie::get('locale'));
	}
	
	function facebookAvatar($url,$fId)
	{
		if($url==null){
			return null;
		}
		
		$contents = file_get_contents($url);
		
		$fileName='public/facebook_avatars/'.$fId.'.jpeg';
		Storage::put($fileName,$contents,'public');
		$url=Storage::url($fileName);
		
		return $url;
	}
	
	
	function newNickname($nick)
	{
		$i=rand(0,9);
		
		$count=User::where('name',$nick)->count();
		if($count>0){
			$nick=$nick.$i;
			
			return $this->newNickname($nick);
		}else{
			return $nick;
		}
	}
	
	function checkEmail($mail)
	{
		$count=User::where('email',$mail)->count();
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
}
