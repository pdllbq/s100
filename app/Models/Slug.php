<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    function make($text)
	{
		$i=0;
		$salt='';
		
		$slug=\Str::slug($text);
		while(Post::where('slug',$slug.$salt)->exists() || $slug==''){
			if($i==0){
				$salt='-'.Carbon::now()->format('d-m-Y');
			}elseif($i==1){
				$salt='-'.Carbon::now()->format('d-m-Y').'-'.\Auth::user()->name;
			}else{
				$salt='-'.$i;
			}
			$i++;
		}
		
		if(strlen($slug.$salt)>255 || $this->routeExists($slug.$salt)){
			$slug=$this->makeRandomSlug();
			$salt='';
		}
		
		return $slug.$salt;
	}
}
