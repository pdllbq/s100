<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	static function isBanned($name)
	{
		$name=str_replace('@','',$name);
		$user=self::where('name',$name)->first();
		if(!isset($user->id)){
			return false;
		}
		
		if(Carbon::now()->lt($user->ban_until)){
			return Carbon::parse($user->ban_until)->format('d.m.Y H:i');
		}
		
		return false;
	}
}
