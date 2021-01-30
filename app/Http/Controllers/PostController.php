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
use App\Models\PostTempSave;
use Carbon\Carbon;
use App\Models\PostsReaded;

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
		
		$posts=$Post::where('lang',app()->getLocale())->where('draft','!=',1)->where('in_sandbox','!=',1)->orderBy('24h_rating','desc')->orderBy('id','desc')->with(['user','voted','group'])->paginate(100);
		//$posts=$Post->voted($posts,$userId);
		
		$description=__('description.Best');
		
        return view('post.index',['posts'=>$posts,'topUsers'=>$topUsers,'topGroups'=>$topGroups,'title'=>$title,'description'=>$description]);
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
		
		$posts=$posts->where('draft','!=',1);
		
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
		
		$posts=$Post::where('lang',app()->getLocale())->where('draft','!=',1)->where('in_sandbox','!=',1)->orderBy('id','desc')->with(['user','voted'])->paginate(100);
		//$posts=$Post->voted($posts,$userId);
		
		$description=__('description.New');
		
        return view('post.index',['posts'=>$posts,'topUsers'=>$topUsers,'topGroups'=>$topGroups,'title'=>$title,'description'=>$description]);
	}
	
	public function sandbox()
	{
		$title=__('post.Sandbox');
		
		if(isset(\Auth::user()->id)){
			$userId=\Auth::user()->id;
		}else{
			$userId=false;
		}
		
		$topUsers=User::where('id','>',0)->orderBy('rating','DESC')->limit(10)->get();
		$topGroups=Group::where('id','>',0)->orderBy('subscribers_count','DESC')->limit(10)->get();
		
		$posts=Post::where('lang',app()->getLocale())->where('draft','!=',1)->where('in_sandbox',1)->orderBy('id','desc')->with(['user','voted'])->paginate(100);
		
		$description=__('description.Sandbox');
		
		return view('post.index',['posts'=>$posts,'topUsers'=>$topUsers,'topGroups'=>$topGroups,'title'=>$title,'description'=>$description]);
	}
	
	function moderation()
	{
		$title=__('post.Moderation');
		
		if(!isset(\Auth::user()->id) || \Auth::user()->is_moder!=1){
			return redirect('/404');
		}

		$topUsers=User::where('id','>',0)->orderBy('rating','DESC')->limit(10)->get();
		$topGroups=Group::where('id','>',0)->orderBy('subscribers_count','DESC')->limit(10)->get();
		
		$posts=Post::where('is_moderated',0)->orderBy('id','asc')->with(['user','voted'])->paginate(100);
		
		return view('post.index',['posts'=>$posts,'topUsers'=>$topUsers,'topGroups'=>$topGroups,'title'=>$title]);
	}
	
	public function readed()
	{
		$title=__('post.Readed');
		
		$Post=new Post;
		
		if(isset(\Auth::user()->id)){
			$userId=\Auth::user()->id;
			$userName=\Auth::user()->name;
		}else{
			$userId=false;
			$userName=null;
		}
		
		$topUsers=User::where('id','>',0)->orderBy('rating','DESC')->limit(10)->get();
		$topGroups=Group::where('id','>',0)->orderBy('subscribers_count','DESC')->limit(10)->get();
		
		$slugs=PostsReaded::select('slug')->where('user_name',$userName)->orderBy('id','desc')->get()->toArray();
		
		$posts=$Post::whereIn('slug',$slugs)->with(['user','voted'])->paginate(100);
		
        return view('post.index',['posts'=>$posts,'topUsers'=>$topUsers,'topGroups'=>$topGroups,'title'=>$title]);
	}
	
	public function iLike()
	{
		$title=__('post.You liked');
		
		$Post=new Post;
		
		if(isset(\Auth::user()->id)){
			$userId=\Auth::user()->id;
		}else{
			$userId=false;
		}
		
		$topUsers=User::where('id','>',0)->orderBy('rating','DESC')->limit(10)->get();
		$topGroups=Group::where('id','>',0)->orderBy('subscribers_count','DESC')->limit(10)->get();
		
		$slugs=Rating::select('post_slug')->where('user_id',$userId)->where('type','+')->orderBy('id','desc')->get()->toArray();
		
		$posts=$Post::whereIn('slug',$slugs)->with(['user','voted'])->paginate(100);
		
        return view('post.index',['posts'=>$posts,'topUsers'=>$topUsers,'topGroups'=>$topGroups,'title'=>$title]);
	}
	
	public function draft()
	{
		$title=__('post.Draft');
		
		$Post=new Post;
		
		if(isset(\Auth::user()->id)){
			$userId=\Auth::user()->id;
		}else{
			$userId=false;
		}
		
		$topUsers=User::where('id','>',0)->orderBy('rating','DESC')->limit(10)->get();
		$topGroups=Group::where('id','>',0)->orderBy('subscribers_count','DESC')->limit(10)->get();
		
		$posts=$Post::where('user_id',$userId)->where('draft',1)->orderBy('id','desc')->with(['user','voted'])->paginate(100);
		
        return view('post.index',['posts'=>$posts,'topUsers'=>$topUsers,'topGroups'=>$topGroups,'title'=>$title]);
	}
	
	function preTag($tag)
	{
		return redirect()->route('post.tag',[session('locale','lv'),$tag]);
	}
	
	function tag($locale,$tag)
	{
		
		$title='#'.$tag;
		
		$posts=Post::where('tags','like','%#'.$tag.',%')->orWhere('tags','like','#'.$tag.',%')->orWhere('tags','like','#'.$tag.',')->where('draft','!=',1)->with(['user','voted'])->orderBy('24h_rating','desc')->paginate(100);
		
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
		
		//Ограничение на один пост в час
		$canCreate=$this->canCreatePost();
		//
		
		$ban=User::isBanned(\Auth::user()->name);
		
		$oldTitle=null;
		$oldGroup=null;
		$oldText=null;
		
		$old=PostTempSave::where('user_name',\Auth::user()->name)->first();
		if(isset($old->user_name)){
			$oldTitle=$old->title;
			$oldGroup=$old->group_slug;
			$oldText=$old->text;
		}

		if($canCreate==0){
			$lastPost=Post::where('user_id',\Auth::user()->id)->where('draft','!=',1)->orderBy('id','DESC')->first();
			$nextPost=Carbon::parse($lastPost->created_at)->addHour()->addMinute()->toTimeString();
		}else{
			$nextPost=0;
		}
		
        return view('post.create',['groups'=>$groups,'canCreate'=>$canCreate,'nextPost'=>$nextPost,'ban'=>$ban,'oldTitle'=>$oldTitle,'oldText'=>$oldText,'oldGroup'=>$oldGroup]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\StorePostRequest $request)
    {
		//Only logged in users or with api key and userId
		if(!\Auth::check() && !isset($userId)){
			session(['after_auth'=>\route('post.create',app()->getLocale())]);
			return redirect()->route('login',app()->getLocale());
		}else{
			$userId=\Auth::id();
		}
		//
		
		if(User::isBanned(\Auth::user()->name)){
			return redirect()->route('post.create',[app()->getLocale()]);
		}
		
		
		//Ограничение на один пост в час
		$canCreate=$this->canCreatePost();
		//
		
		if($canCreate==0){
			return redirect()->route('post.create',[app()->getLocale()]);
		}
		
		
        $inputs=$request->input();
		
		if(!isset($inputs['iframe_mode'])){
			$inputs['iframe_mode']=0;
		}
		if(!isset($inputs['iframe_url'])){
			$inputs['iframe_url']='';
		}
		if(!isset($inputs['sandbox'])){
			if(\Auth::user()->is_moder==1){
				$inputs['sandbox']=0;
			}else{
				$inputs['sandbox']=1;
			}
		}
		
		$Post=new Post;
		$Post->user_id=$userId;
		$Post->title=$inputs['title'];
		$Post->group_slug=$inputs['group'];
		$Post->text=$inputs['text'];
		$Post->iframe_mode=$inputs['iframe_mode'];
		$Post->iframe_url=$inputs['iframe_url'];
		$Post->in_sandbox=$inputs['sandbox'];
		$Post->lang=\app()->getLocale();
		if(isset($inputs['draft']) && $inputs['draft']=='on'){
			$Post->draft=1;
		}else{
			$Post->draft=0;
		}
		
		if(\Auth::user()->is_moder!=1){
			$Post->in_sandbox=1;
		}else{
			$Post->is_moderated=1;
		}
		
		$Post->save();
		
		PostTempSave::where('user_name',\Auth::user()->name)->delete();
		
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
		
		if(isset(\Auth::user()->name)){
			$ban=User::isBanned(\Auth::user()->name);
			$userName=\Auth::user()->name;
		}else{
			$ban=false;
			$userName=null;
		}
		
		$post->date=Carbon::parse($post->created_at)->format('d.n.Y');
		
		$PostsReaded=new PostsReaded;
		
		$PostsReaded->readed($slug,\Request::ip(),$userName);
		
        return view('post.show',['post'=>$post,'comments'=>$comments,'ban'=>$ban]);
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
		
		if(!isset($inputs['iframe_mode'])){
			$inputs['iframe_mode']=0;
		}
		if(!isset($inputs['iframe_url'])){
			$inputs['iframe_url']='';
		}
		if(!isset($inputs['sandbox'])){
			if(\Auth::user()->is_moder==1){
				$inputs['sandbox']=0;
			}else{
				$inputs['sandbox']=1;
			}
		}
		
		$post->title=$inputs['title'];
		$post->group_slug=$inputs['group'];
		$post->text=$inputs['text'];
		$post->iframe_mode=$inputs['iframe_mode'];
		$post->iframe_url=$inputs['iframe_url'];
		$post->in_sandbox=$inputs['sandbox'];
		$post->lang=\app()->getLocale();
		if(isset($inputs['draft']) && $inputs['draft']=='on'){
			$post->draft=1;
		}else{
			$post->draft=0;
		}
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
		
		if($post->user_id!=\Auth::id() && \Auth::user()->is_moder==1){
			Post::where('slug',$slug)->update(['delete_name'=>\Auth::user()->name]);
			Post::find($post->id)->delete();
		}elseif($post->user_id==\Auth::id()){
			Post::find($post->id)->forceDelete();
		}
		
		if($post->user_id!=\Auth::id()){
			return redirect()->route('home',app()->getLocale());
		}
		
		$Rating->deleteRating($slug);
		
		return redirect()->route('home',app()->getLocale())->withSuccess(__('post.Post was deleted'));
    }
	
	public function onlyAuth()
	{
		$this->middleware('auth');
		
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
		
		$ban=User::isBanned(\Auth::user()->name);
		if($ban){
			$data=['ban'=>1,'banText'=>__('user.You are banned until :time',['time'=>$ban])];
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
		
		$ban=User::isBanned(\Auth::user()->name);
		if($ban){
			$data=['ban'=>1,'banText'=>__('user.You are banned until :time',['time'=>$ban])];
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
		
		if(User::isBanned(\Auth::user()->name)){
			return redirect()->route('post.show',[app()->getLocale(),$inputs['post-slug'],'#comments']);
		}
		
		
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
	
	//Ограничение на один пост в час
	function canCreatePost()
	{
		if(\Auth::user()->post_limit==1){
			$time=Carbon::now()->subHour(1);
			$result=Post::where('user_id',\Auth::user()->id)->where('created_at','>=',$time)->count();

			if($result>0){
				$canCreate=0;
			}else{
				$canCreate=1;
			}
		}else{
			$canCreate=1;
		}
		
		return $canCreate;
	}
	
	
	function tempSave(Request $request)
	{
		$PostTempSave=new PostTempSave;
		
		$title=$request->input('title');
		$group=$request->input('group');
		$text=$request->input('text');
		
		$PostTempSave->store(\Auth::user()->name,$title,$group,$text);
	}
	
	function fromSandbox($locle,$slug)
	{
		if(!isset(\Auth::user()->id) || \Auth::user()->is_moder!=1)
		{
			return redirect('/404');
		}
		
		Post::where('slug',$slug)->update(['in_sandbox'=>0,'is_moderated'=>1,'moder_name'=>\Auth::user()->name]);
		
		return redirect()->route('post.moder',[\app()->getLocale()]);
	}
	
	function toSandbox($locle,$slug)
	{
		if(!isset(\Auth::user()->id) || \Auth::user()->is_moder!=1)
		{
			return redirect('/404');
		}
		
		Post::where('slug',$slug)->update(['in_sandbox'=>1,'is_moderated'=>1,'moder_name'=>\Auth::user()->name]);
		
		return redirect()->route('post.moder',[\app()->getLocale()]);
	}
}
