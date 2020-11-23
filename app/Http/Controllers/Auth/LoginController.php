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
	
	function handleFacebookCallback()
	{
		if($_SERVER['SERVER_NAME']=='localhost'){
			return redirect('http://s100.loc/login/facebook/callback?code='.$_GET['code'].'&state='.$_GET['state']);
		}
		
		$user = Socialite::driver('facebook')->user();
		$this->facebookAuth($user);
		// $user->token;
		
		return redirect('/');
	}
	
	function redirectToFacebook()
	{
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
			
			$User=new User;
			$User->name=$name;
			$User->facebook_id=$facebookUser->id;
			$User->email=$facebookUser->email;
			$User->avatar=$this->facebookAvatar($facebookUser->avatar_original,$facebookUser->id);
			$User->password=Hash::make(Str::random(12));
			$User->save();
			
			$this->facebookAuth($facebookUser);
		}else{
			\Auth::loginUsingId($user->id,true);
		}
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
	
}
