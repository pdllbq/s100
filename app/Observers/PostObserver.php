<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\User;
use Exception;

class PostObserver
{
	protected $allowedFiles=[
		'data:image/png',
		'data:image/jpeg',
		'data:image/jpg',
		'data:image/gif'
	];


	/**
     * Handle the post "created" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        
    }
	
	public function creating(Post $post)
    {
        //dd($post);
		
		$post->slug=$this->makeSlug($post);
		$this->saveImages($post);
		$this->htmlTagsToBb($post);
		$this->makeTags($post);
		$post->html=$this->textToHtml($post);
		$this->makeTags($post); //Второй раз-так надо, иначе не работает
		
		//dd($post->html);
		$post->excerpt=$this->truncate($post->html,255,array('html' => true, 'ending' => '...'));
		//$post->excerpt_no_html=$this->truncate($post->html,255,array('html' => false, 'ending' => '...'));
		$post->excerpt_no_html= strip_tags($post->excerpt);
		
		$user=User::where('id',\Auth::id())->first();
		
		$post->{'24h_rating'}=$user->rating;
		
		//dd($post);
	}
	
	function truncate($text, $length = 100, $options = array()) {
		$default = array(
			'ending' => '...', 'exact' => true, 'html' => false
		);
		$options = array_merge($default, $options);
		extract($options);

		if ($html) {
			if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}
			$totalLength = mb_strlen(strip_tags($ending));
			$openTags = array();
			$truncate = '';

			preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
			foreach ($tags as $tag) {
				if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
					if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
						array_unshift($openTags, $tag[2]);
					} else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
						$pos = array_search($closeTag[1], $openTags);
						if ($pos !== false) {
							array_splice($openTags, $pos, 1);
						}
					}
				}
				$truncate .= $tag[1];

				$contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
				if ($contentLength + $totalLength > $length) {
					$left = $length - $totalLength;
					$entitiesLength = 0;
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
						foreach ($entities[0] as $entity) {
							if ($entity[1] + 1 - $entitiesLength <= $left) {
								$left--;
								$entitiesLength += mb_strlen($entity[0]);
							} else {
								break;
							}
						}
					}

					$truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
					break;
				} else {
					$truncate .= $tag[3];
					$totalLength += $contentLength;
				}
				if ($totalLength >= $length) {
					break;
				}
			}
		} else {
			if (mb_strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = mb_substr($text, 0, $length - mb_strlen($ending));
			}
		}
		if (!$exact) {
			$spacepos = mb_strrpos($truncate, ' ');
			if (isset($spacepos)) {
				if ($html) {
					$bits = mb_substr($truncate, $spacepos);
					preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
					if (!empty($droppedTags)) {
						foreach ($droppedTags as $closingTag) {
							if (!in_array($closingTag[1], $openTags)) {
								array_unshift($openTags, $closingTag[1]);
							}
						}
					}
				}
				$truncate = mb_substr($truncate, 0, $spacepos);
			}
		}
		$truncate .= $ending;

		if ($html) {
			foreach ($openTags as $tag) {
				$truncate .= '</'.$tag.'>';
			}
		}

		return $truncate;
	}
	
	function makeExcerpt($post)
	{
		$post=strip_tags($post);
		
		$count=mb_strlen($post);
		
		if($count>110){
			$excerpt=mb_substr($post,55).'...';
		}else{
			return NULL;
		}
		
		return $excerpt;
	}
	
	public function updating(Post $post)
	{
		//dd($post);
		
		
		$this->saveImages($post);
		$this->htmlTagsToBb($post);
		//dd($post->text);
		$this->makeTags($post);
		//dd($post->text);
		$post->html=$this->textToHtml($post);
		
		//dd($post->html);
		$post->excerpt=$this->truncate($post->html,255,array('html' => true, 'ending' => '...'));
		//$post->excerpt_no_html=$this->truncate($post->html,255,array('html' => false, 'ending' => '...'));
		$post->excerpt_no_html= strip_tags($post->excerpt);
		//dd($post);
	}

	/**
     * Handle the post "updated" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }
	
	function deleting(Post $post)
	{
		$dom = new \DomDocument('1.0', 'UTF-8');
		try{
			$dom->loadHtml(mb_convert_encoding($post->html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
		}catch(Exception $e){
			$e=1;
		}
		$imgs=$dom->getElementsByTagName('img');
		
		//dd($imgs);
		
		$savedImages=[];
		
		foreach($imgs as $key=>$img){
			$image=$img->getAttribute('src');
			$data=explode(';',$image);
			
			$data[0]=str_replace('/storage/','/storage/app/public/',$data[0]);
			
			//dd($data[0]);
			
			if(file_exists(base_path().$data[0])){
				unlink(base_path().$data[0]);
			}
		}
		
		Comment::deleteAllByPostSlug($post->slug);
	}
	

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
       // dd($post);
    }

    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //dd($post);
    }
	
	protected function saveImages(Post $post)
	{
		//dd($post->text);
		
		$dom = new \DomDocument('1.0', 'UTF-8');
		$dom->loadHtml(mb_convert_encoding($post->text, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
		$imgs=$dom->getElementsByTagName('img');
		
		//dd($imgs);
		
		$savedImages=[];
		
		foreach($imgs as $key=>$img){
			$image=$img->getAttribute('src');
			$data=explode(';',$image);
			$extension=explode('/',$data[0]);
			$extension=$extension[1];
			$i=0;
			//dd($data);
			
			if(isset($data[1])){
				if(array_search($data[0],$this->allowedFiles)!==false){
					$fileName='public/post-files/user-'.$post->user_id.'/'.$post->slug.'.'.$extension;
					while(Storage::exists($fileName)){
						$fileName='public/post-files/user-'.$post->user_id.'/'.$post->slug.'-'.$i.'.'.$extension;
						$i++;
					}

					//dd($fileName);

					Storage::put($fileName, base64_decode(str_replace('base64,','',$data[1])));
					$savedImages[]=$fileName;

					$style=$img->getAttribute('style');
					$img->removeAttribute('src');
					$img->setAttribute('src', Storage::url($fileName));
					$img->setAttribute('onclick','showImage(\''.Storage::url($fileName).'\')');
					$img->setAttribute('style',$style.' cursor:pointer;');
				}else{
					$img->removeAttribute('src');
				}
			}
			
			$img->removeAttribute('data-filename');
			
			$post->text=$dom->saveHTML($dom->documentElement);
		}
		
		$post->files='';
		foreach($savedImages as $img){
			$post->files.=$img.',';
		}
		
	}
	
	protected function makeSlug(Post $post)
	{
		$i=0;
		$salt='';
		
		$slug=\Str::slug($post->title);
		while(Post::where('slug',$slug.$salt)->exists()){
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
	
	protected function makeRandomSlug()
	{
		$simbols=['1','2','3','4','5','6','7','8','9','0','-','q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m','Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M'];
		
		$slug=$simbols[array_rand($simbols)];
		
		while(Post::where('slug',$slug)->exists()){
			$slug=$slug.$simbols[array_rand($simbols)];
		}
		
		return $slug;
	}
	
	protected function makeTags(Post $post)
	{
		preg_match_all('/(#\w+)/u', $post->html, $tags);
		
		$post->tags='';
		
		foreach ($tags[0] as $tag){
			$post->tags.=$tag.',';
		}
		
		$post->text=preg_replace('/#(\w+)/u','[hashTag]$1[/hashTag]', $post->text);
	}
	
	protected function htmlTagsToBb(Post $post)
	{
		$post->text=preg_replace('/<a href="(.*?)"(.*?)><\/a>/im','', $post->text);
		//$post->text=preg_replace('/<img style="(.*?)" src="(.*?)">/im','[img style=$1]$2[/img]', $post->text);
		$post->text=preg_replace('/<img style="(.*?)" src="(.*?)" onclick="(.*?)">/im','[img style=$1]$2[/img]', $post->text);
		$post->text=$this->p($post->text);
		$post->text=preg_replace('/<p align="(.*?)">(.*?)<\/p>/im','[p align=$1]$2[/p]', $post->text);
		$post->text= str_replace('<br>', '[br]',$post->text);
		$post->text=preg_replace('/<blockquote class="blockquote">(.*?)<\/blockquote>/im','[blockquote]$1[/blockquote]', $post->text);
		$post->text=preg_replace('/<b>(.*?)<\/b>/im','[b]$1[/b]', $post->text);
		$post->text=preg_replace('/<h1>(.*?)<\/h1>/im','[h1]$1[/h1]', $post->text);
		$post->text=preg_replace('/<h2>(.*?)<\/h2>/im','[h2]$1[/h2]', $post->text);
		$post->text=preg_replace('/<h3>(.*?)<\/h3>/im','[h3]$1[/h3]', $post->text);
		$post->text=preg_replace('/<h4>(.*?)<\/h4>/im','[h4]$1[/h4]', $post->text);
		$post->text=preg_replace('/<h5>(.*?)<\/h5>/im','[h5]$1[/h5]', $post->text);
		$post->text=preg_replace('/<h6>(.*?)<\/h6>/im','[h6]$1[/h6]', $post->text);
		$post->text=preg_replace('/<u>(.*?)<\/u>/im','[u]$1[/u]', $post->text);
		$post->text=preg_replace('/<span style="background-color: rgb\((.*?)\);">(.*?)<\/span>/im','[backgroundColor=rgb($1)]$2[/backgroundColor]', $post->text);
		$post->text=preg_replace('/<font color="#(.*?)">(.*?)<\/font>/im','[fontColor=$1]$2[/fontColor]', $post->text);
		$post->text=preg_replace('/<ul>(.*?)<\/ul>/im','[ul]$1[/ul]', $post->text);
		$post->text=preg_replace('/<li>(.*?)<\/li>/sim','[li]$1[/li]', $post->text);
		$post->text=preg_replace('/<ol>(.*?)<\/ol>/sim','[ol]$1[/ol]', $post->text);
		$post->text=preg_replace('/<div align="(.*?)">(.*?)<\/div>/im','[align=$1]$2[/align]', $post->text);
		$post->text=preg_replace('/<table class="table table-bordered">(.*?)<\/table>/im','[table]$1[/table]', $post->text);
		$post->text=preg_replace('/<tbody>(.*?)<\/tbody>/im','[tbody]$1[/tbody]', $post->text);
		$post->text=preg_replace('/<tr>(.*?)<\/tr>/im','[tr]$1[/tr]', $post->text);
		$post->text=preg_replace('/<td>(.*?)<\/td>/im','[td]$1[/td]', $post->text);
		$post->text=preg_replace('/<a href="([^"]+)" target="_blank">(.*?)<\/a>/','[link=$1]$2[/link]', $post->text);
		$post->text=preg_replace('/<a href="[^"]+">#(.*?)<\/a>/','[hashTag]$1[/hashTag]', $post->text);
		$post->text=preg_replace('/<iframe src="\/\/www.youtube.com\/embed\/(.*?)"(.*?)<\/iframe>/im','[youtube]$1[/youtube]', $post->text);
	}
	
	function p($text)
	{
		
		$i=0;
		while(strpos($text,'<p>')!==false && strpos($text,'</p>')!==false){
			$text=preg_replace('/<p>(.*?)<\/p>/s','[p]$1[/p]', $text);
			$i++;
			if($i==100){
				dd($text);
			}
		}
		
		return $text;
	}
	
	function pbb($text)
	{
		while(strpos($text,'[p]')!==false && strpos($text,'[/p]')!==false){
			$text=preg_replace('/\[p\](.*?)\[\/p\]/s','<p>$1</p>', $text);
		}
		
		return $text;
	}
	
	protected function textToHtml(Post $post)
	{
		$html=$post->text;
		
		$html= htmlspecialchars($html);
		
		//$html=preg_replace('~\[img style=(.*?)\](.*?)\[/img\]~','<img style="$1" src="$2">', $html);
		$html=preg_replace('~\[img style=(.*?)\](.*?)\[/img\]~','<img style="$1" src="$2" onclick="showImage(\'$2\')">', $html);
		$html=$this->pbb($html);
		$html=preg_replace('~\[p align=(.*?)\](.*?)\[/p\]~','<p align="$1">$2</p>', $html);
		$html= str_replace('[br]','<br>', $html);
		$html=preg_replace('~\[blockquote\](.*?)\[/blockquote\]~im','<blockquote class="blockquote">$1</blockquote>', $html);
		$html=preg_replace('~\[b\](.*?)\[/b\]~im','<b>$1</b>', $html);
		$html=preg_replace('~\[h1\](.*?)\[/h1\]~im','<h1>$1</h1>', $html);
		$html=preg_replace('~\[h2\](.*?)\[/h2\]~im','<h2>$1</h2>', $html);
		$html=preg_replace('~\[h3\](.*?)\[/h3\]~im','<h3>$1</h3>', $html);
		$html=preg_replace('~\[h4\](.*?)\[/h4\]~im','<h4>$1</h4>', $html);
		$html=preg_replace('~\[h5\](.*?)\[/h5\]~im','<h5>$1</h5>', $html);
		$html=preg_replace('~\[h6\](.*?)\[/h6\]~im','<h6>$1</h6>', $html);
		$html=preg_replace('~\[u\](.*?)\[/u\]~im','<u>$1</u>', $html);
		$html=preg_replace('~\[backgroundColor=(.*?)\](.*?)\[/backgroundColor\]~im','<span style="background-color: $1;">$2</span>', $html);
		$html=preg_replace('~\[fontColor=(.*?)\](.*?)\[/fontColor\]~im','<font color="#$1">$2</font>', $html);
		$html=preg_replace('~\[ul\](.*?)\[/ul\]~im','<ul>$1</ul>', $html);
		$html=preg_replace('~\[li\](.*?)\[/li\]~sim','<li>$1</li>', $html);
		$html=preg_replace('~\[ol\](.*?)\[/ol\]~sim','<ol>$1</ol>', $html);
		$html=preg_replace('~\[align=(.*?)\](.*?)\[/align\]~im','<div align="$1">$2</div>', $html);
		$html=preg_replace('~\[table\](.*?)\[/table\]~im','<table class="table table-bordered">$1</table>', $html);
		$html=preg_replace('~\[tbody\](.*?)\[/tbody\]~im','<tbody>$1</tbody>', $html);
		$html=preg_replace('~\[tr\](.*?)\[/tr\]~im','<tr>$1</tr>', $html);
		$html=preg_replace('~\[td\](.*?)\[/td\]~im','<td>$1</td>', $html);
		$html=preg_replace('~\[link=(.*?)\](.*?)\[/link\]~im','<a href="$1" target="_blank">$2</a>', $html);
		$html=preg_replace('~\[youtube\](.*?)\[/youtube\]~im','<div class="video-responsive"><iframe src="//www.youtube.com/embed/$1" class="note-video-clip" width="640" height="360" frameborder="0"></iframe></div>', $html);
		$html=preg_replace('~\[hashTag\](.*?)\[/hashTag\]~','<a href="/tag/$1">#$1</a>', $html);
		
		return $html;	
	}
	
	function routeExists($route)
	{
		$routeCollection = app()->routes->getRoutes();
		
		foreach ($routeCollection as $value) {
			if(str_replace('{locale}/','',$value->uri())==$route){
				return true;
			}
		}
		
		return false;
	}
}
