<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Post;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Subscribe;
use App\Models\Group;
use App\User;
use App\Models\Notification;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
		$title=__('post.Best');
		
		$back=session('after_auth');
		if($back){
			session(['after_auth'=>false]);
			return redirect($back);
		}
		
		$Post=new Post;
		
		if(isset(\Auth::user()->id)){
			$userId=\Auth::user()->id;
		}else{
			$userId=false;
		}
		
		$topUsers=User::where('id','>',0)->orderBy('rating','DESC')->limit(10)->get();
		$topGroups=Group::where('id','>',0)->orderBy('subscribers_count','DESC')->limit(10)->get();
		
		$posts=$Post::where('lang',app()->getLocale())->orderBy('24h_rating','desc')->with(['user','voted','group'])->paginate(100);
		//$posts=$Post->voted($posts,$userId);
		
        return view('post.index',['posts'=>$posts,'topUsers'=>$topUsers,'topGroups'=>$topGroups,'title'=>$title]);
    }
	
	public function subscribes()
	{
		$title=__('post.Subscribes');
		
		$Post=new Post;
		
		if(isset(\Auth::user()->id)){
			$userId=\Auth::user()->id;
		}else{
			$userId=false;
		}
		
		//Subscribed to users, groups, tags
		$sub['users']=Subscribe::select('slave_id')->where('master_id',$userId)->where('slave_id','!=',0)->get()->toArray();
		$sub['groups']=Subscribe::select('group_slug')->where('master_id',$userId)->where('group_slug','!=',NULL)->get()->toArray();
		$sub['tags']=Subscribe::select('tag_name')->where('master_id',$userId)->where('tag_name','!=',NULL)->get()->toArray();
		//
		
		$posts=$Post::whereIn('user_id',$sub['users'])->orWhereIn('group_slug',$sub['groups']);
		
		foreach($sub['tags'] as $tag){
			$posts=$posts->orWhere('tags','like','%'.$tag['tag_name'].'%');
		}
		
		$topUsers=User::where('id','>',0)->orderBy('rating','DESC')->limit(10)->get();
		$topGroups=Group::where('id','>',0)->orderBy('subscribers_count','DESC')->limit(10)->get();
		
		$posts=$posts->orderBy('id','desc')->with(['user','voted'])->paginate(100);
		//$posts=$Post->voted($posts,$userId);
		
        return view('post.index',['posts'=>$posts,'topUsers'=>$topUsers,'topGroups'=>$topGroups,'title'=>$title]);
	}
	
	public function new()
	{
		$title=__('post.New');
		
		$Post=new Post;
		
		if(isset(\Auth::user()->id)){
			$userId=\Auth::user()->id;
		}else{
			$userId=false;
		}
		
		$topUsers=User::where('id','>',0)->orderBy('rating','DESC')->limit(10)->get();
		$topGroups=Group::where('id','>',0)->orderBy('subscribers_count','DESC')->limit(10)->get();
		
		$posts=$Post::where('lang',app()->getLocale())->orderBy('id','desc')->with(['user','voted'])->paginate(100);
		//$posts=$Post->voted($posts,$userId);
		
        return view('post.index',['posts'=>$posts,'topUsers'=>$topUsers,'topGroups'=>$topGroups,'title'=>$title]);
	}
	
	function preTag($tag)
	{
		return redirect()->route('post.tag',[session('locale','lv'),$tag]);
	}
	
	function tag($locale,$tag)
	{
		$title='#'.$tag;
		
		$posts=Post::where('tags','like','%#'.$tag.',%')->with(['user','voted'])->orderBy('24h_rating','desc')->paginate(100);
		
		if(isset(\Auth::user()->id)){
			$subscribed=Subscribe::where('master_id',\Auth::user()->id)->where('tag_name','#'.$tag)->count();
		}else{
			$subscribed=0;
		}
		
		$subscribers=Subscribe::where('tag_name','#'.$tag)->count();
		
		return view('post.index',['posts'=>$posts,'tag'=>$tag,'subscribed'=>$subscribed,'subscribers'=>$subscribers,'title'=>$title]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		if(!\Auth::check()){
			session(['after_auth'=>\route('post.create',app()->getLocale())]);
			return redirect()->route('login',app()->getLocale());
		}
		
		//User groups
		$groups=Group::where('user_id',\Auth::user()->id)->get();
		//
		
		//dd($groups);
		
        return view('post.create',['groups'=>$groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\StorePostRequest $request)
    {
		//Only logged in users
		if(!\Auth::check()){
			session(['after_auth'=>\route('post.create',app()->getLocale())]);
			return redirect()->route('login',app()->getLocale());
		}
		//
		
        $inputs=$request->input();
		
		$Post=new Post;
		$Post->user_id=\Auth::id();
		$Post->title=$inputs['title'];
		$Post->group_slug=$inputs['group'];
		$Post->text=$inputs['text'];
		$Post->lang=\app()->getLocale();
		$Post->save();
		
		return redirect()->route('post.show',[app()->getLocale(),$Post->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  str  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($lang,$slug)
    {
		$post=Post::where('slug',$slug)->first();
		
		$comments=Comment::where('post_slug',$slug)->where('answer_id',0)->get();
		
		if(!isset($post->id)){
			return abort(404);
		}
		
        return view('post.show',['post'=>$post,'comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  str  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($lang,$slug)
    {
		//Only logged in users
		if(!\Auth::check()){
			session(['after_auth'=>\route('post.create',app()->getLocale())]);
			return redirect()->route('login',app()->getLocale());
		}
		//
		
		//User groups
		$groups=Group::where('user_id',\Auth::user()->id)->get();
		//
		
        $post=Post::where('slug',$slug)->first();
		
		if($post->user_id!=\Auth::id()){
			return redirect()->route('home',app()->getLocale());
		}
		
		return view('post.edit',['post'=>$post,'groups'=>$groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  str  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\StorePostRequest $request,$lang, $slug)
    {
		//Only logged in users
		if(!\Auth::check()){
			session(['after_auth'=>\route('post.create',app()->getLocale())]);
			return redirect()->route('login',app()->getLocale());
		}
		//
		
        $post=Post::where('slug',$slug)->first();
		
		if($post->user_id!=\Auth::id()){
			return redirect()->route('home',app()->getLocale());
		}
		
		$inputs=$request->input();
		
		$post->title=$inputs['title'];
		$post->group_slug=$inputs['group'];
		$post->text=$inputs['text'];
		$post->lang=\app()->getLocale();
		$post->save();
		
		return redirect()->route('post.show',[app()->getLocale(),$post->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang,$slug)
    {
		$Rating=new Rating;
		
        //Only logged in users
		if(!\Auth::check()){
			session(['after_auth'=>\route('post.create',app()->getLocale())]);
			return redirect()->route('login',app()->getLocale());
		}
		//
		
		$post=Post::where('slug',$slug)->first();
		
		if($post->user_id!=\Auth::id()){
			return redirect()->route('home',app()->getLocale());
		}
		
		
		
		Post::where('slug',$slug)->first()->delete();
		
		$Rating->deleteRating($slug);
		
		return redirect()->route('home',app()->getLocale())->withSuccess(__('post.Post was deleted'));
    }
	
	public function onlyAuth()
	{
		$this->middleware('auth');
		
//		dd(\Auth::check());
//		
//		if(!\Auth::check()){
//			return redirect()->route('login',app()->getLocale());
//		}
	}
	
	public function plus($lang,$slug)
	{
		if(!isset(\Auth::user()->id)){
			$data=['auth'=>1,'redirect'=>route('login',app()->getLocale())];
			return json_encode($data);
		}
		
		$Rating=new Rating;
		
		$Rating->plus($slug, \Auth::user()->id);
		
		return json_encode(['rating'=>$Rating->getRating($slug)]);
	}
	
	public function minus($lang,$slug)
	{
		if(!isset(\Auth::user()->id)){
			$data=['auth'=>1,'redirect'=>route('login',app()->getLocale())];
			return json_encode($data);
		}
		
		$Rating=new Rating;
		
		$Rating->minus($slug, \Auth::user()->id);
		
		return json_encode(['rating'=>$Rating->getRating($slug)]); 
	}
	
	function addComment(\App\Http\Requests\StoreCommentRequest $request)
	{
		if(!\Auth::check()){
			session(['after_auth'=>\route('post.create',app()->getLocale())]);
			return redirect()->route('login',app()->getLocale());
		}
		
		
		
		$inputs=$request->input();
		
		$Comment=new Comment;
		
		$Comment->user_id=\Auth::user()->id;
		$Comment->answer_id=$inputs['answer-id'];
		$Comment->post_slug=$inputs['post-slug'];
		$Comment->text=$inputs['comment'];
		$Comment->save();
		
		if($inputs['answer-id']!=0){
			$comment=Comment::where('id',$inputs['answer-id'])->first();
			if(isset($comment->id)){
				Notification::newAnswerOnComment($comment->user_id,$Comment->post_slug,$comment->id);
			}
		}
		$commentsCount=Comment::where('post_slug',$inputs['post-slug'])->count();
		
		Post::where('slug',$inputs['post-slug'])->update(['comments_count'=>$commentsCount]);
		
		return redirect()->route('post.show',[app()->getLocale(),$Comment->post_slug,'#comments']);
	}
	
	function commentGetAnswers($locale,$commentId)
	{
		$comments=Comment::where('answer_id',$commentId)->get();
		
		return view('post.include._commentGetAnswers',['comments'=>$comments]);
	}
	
}
