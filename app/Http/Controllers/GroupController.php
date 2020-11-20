<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Post;
use App\Models\Subscribe;

class GroupController extends Controller
{
    function show($locale,$groupSlug)
	{
		$group=Group::where('slug',$groupSlug)->first();
		$posts=Post::where('group_slug',$groupSlug)->orderBy('id','desc')->with(['user','voted'])->paginate(100);
		
		$title=$group->name;
		
		//User is subscribed on this group?
		if(isset(\Auth::user()->id) && \Auth::user()->id){
			$subscribed=Subscribe::where('master_id',\Auth::user()->id)->where('group_slug',$group->slug)->count();
		}else{
			$subscribed=0;
		}
		//
		
		//Subscribers to the group count
		$subscribers=Subscribe::where('group_slug',$group->slug)->count();
		//
		
        return view('post.index',['posts'=>$posts,'group'=>$group,'subscribed'=>$subscribed,'subscribers'=>$subscribers,'title'=>$title]);
	}
	
	function make(\App\Http\Requests\StoreGroupRequest $request)
	{	
		$inputs=$request->input();
		
		if($inputs['name']=='' || !isset(\Auth::user()->id)){
			return redirect()->route('user.profile',[app()->getLocale()]);
		}
		
		$Group=new Group;
		
		$Group->user_id=\Auth::user()->id;
		$Group->name=$inputs['name'];
		$Group->save();
		
		$slug=$Group->slug;
		
		$url=route('group.show',[app()->getLocale(),$slug]);
		
		return \Response::json(['redirect'=>$url]);
	}
	
	function destroy($locale,$slug)
	{
		Post::deleteByGroupSlug($slug);
		
		//dd($posts);
		
		$group=Group::where('slug',$slug)->where('user_id',\Auth::user()->id)->first();
		
		$r=Group::where('slug',$slug)->where('user_id',\Auth::user()->id)->delete();
		
		if($r){
			Post::where('group_slug',$group->slug)->where('user_id',\Auth::user()->id)->delete();
		}
		
		return back();
	}
	
	function store(\App\Http\Requests\StoreGroupRequest $request)
	{
		$inputs=$request->input();
		
		Group::where('id',$inputs['id'])->update([
			'name'=>$inputs['name'],
			'description'=>$inputs['description'],
		]);

		
		return \Response::json(['redirect'=>url()->previous()]);
	}
}
