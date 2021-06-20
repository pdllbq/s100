<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$locale=$request->segment(1);
		
		if($locale && $locale!='ru' && $locale!='lv'){
			return abort('404');
		}
		
		if(isset(\Auth::user()->lang) && !$locale){
			return redirect('/'.\Auth::user()->lang);
		}
		
		if($locale=='ru'){
			app()->setLocale($locale);
			session(['locale' => $locale]);
		}elseif($locale=='lv'){
			app()->setLocale($locale);
			session(['locale' => $locale]);
		}elseif(!$locale){
			return redirect('/ru');
		}else{
			return abort('404');
		}
		//dd(app()->getLocale());
        return $next($request);
    }
}
