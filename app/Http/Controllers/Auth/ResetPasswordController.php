<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Mail;
use App\User;
use Illuminate\Http\Request;
use App\Mail\NewPasswordTokenEmail;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
	
	function newPassword(Request $request)
	{
		$inputs=$request->input();
		
		$count=User::where('email',$inputs['email'])->count();
		
		$token=\Str::random(15);
		
		$Obj=new \stdClass();
		$Obj->token=$token;
		
		User::where('email',$inputs['email'])->update(['password_reset_token'=>$token]);
		
		if($count>0){
			Mail::to($inputs['email'])
					->send(new NewPasswordTokenEmail($Obj));
			
		return view('auth.newPassword');
		}
	}
	
	function saveNewPassword(Request $request)
	{
		$inputs=$request->input();
		
		$user=User::where('email',$inputs['email'])->where('password_reset_token',$inputs['new_password_token'])->first();
		
		if(!isset($user->id)){
			return redirect()->route('password.request',[app()->getLocale()])->with('error','Invalid token');
		}
		
		if($inputs['new_password']!=$inputs['new_password2'] || $inputs['new_password']=='')
		{
			return redirect()->route('password.request',[app()->getLocale()])->with('error','Passwords do not match');
		}
		
		User::where('id',$user->id)->update(['password'=>Hash::make($inputs['new_password'])]);
		
		\Auth::loginUsingId($user->id, true);
		
		return redirect('/')->with('success','Password was updated');
	}
}
