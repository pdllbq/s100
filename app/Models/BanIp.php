<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BanIp extends Model
{
    static function isBanned($ip)
	{
		$count=self::where('ip',$ip)->count();
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
}
