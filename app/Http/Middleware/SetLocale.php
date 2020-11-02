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
		
		if(isset(\Auth::user()->lang) && $locale!=\Auth::user()->lang){
			return redirect('/'.\Auth::user()->lang);
		}
		
		if($locale=='en' || $locale=='ru' || $locale=='lv'){
			app()->setLocale($locale);
			session(['locale' => $locale]);
		}elseif(!$locale){
			return redirect('/lv');
		}
		//dd(app()->getLocale());
        return $next($request);
    }
}
