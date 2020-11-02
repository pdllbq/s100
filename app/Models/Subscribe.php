<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

class Subscribe extends Model
{
    function user($masterId,$slaveId)
	{
		$count=self::where('master_id',$masterId)->where('slave_id',$slaveId)->count();
		
		if($count==0){
			$this->master_id=$masterId;
			$this->slave_id=$slaveId;
			
			$this->save();
		}else{
			self::where('master_id',$masterId)->where('slave_id',$slaveId)->delete();
		}
	}
	
	function tag($masterId,$tag)
	{
		$count=self::where('master_id',$masterId)->where('tag_name',$tag)->count();
		
		if($count==0){
			$this->master_id=$masterId;
			$this->tag_name=$tag;
			
			$this->save();
		}else{
			self::where('master_id',$masterId)->where('tag_name',$tag)->delete();
		}
	}
	
	function group($masterId,$groupSlug)
	{
		$count=self::where('master_id',$masterId)->where('group_slug',$groupSlug)->count();
		
		if($count==0){
			$this->master_id=$masterId;
			$this->group_slug=$groupSlug;
			
			$this->save();
		}else{
			self::where('master_id',$masterId)->where('group_slug',$groupSlug)->delete();
		}
		
		self::updateSubscribersCount($groupSlug);
	}
	
	static function updateSubscribersCount($groupSlug)
	{
		$count=self::where('group_slug',$groupSlug)->count();
		
		Group::where('slug',$groupSlug)->update(['subscribers_count'=>$count]);
	}
}
