<?php

namespace App\Observers;

use App\Models\Group;

class GroupObserver
{
    function creating(Group $group){
		$group->slug=$this->makeSlug($group);
	}
	
	function makeSlug(Group $group)
	{
		$slug=\Str::slug($group->name);
		
		if(Group::where('slug',$slug)->exists()){
			$slug=$this->makeRandomSlug();
		}
		
		return $slug;
	}
	
	function makeRandomSlug()
	{
		$simbols=['1','2','3','4','5','6','7','8','9','0','-','q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m','Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M'];
		
		$slug=$simbols[array_rand($simbols)];
		
		while(Group::where('slug',$slug)->exists()){
			$slug=$slug.$simbols[array_rand($simbols)];
		}
		
		return $slug;
	}
}
