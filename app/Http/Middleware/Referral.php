<?php

namespace App\Http\Middleware;

use Closure;

class Referral
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
		$referral=$request->get('referral');
		
		if($referral!=null){
			$time = time() + 60 * 60 * 24; //One day
			
			$res = $next($request);
			
			//dd($referral);
			return $res->withCookie(cookie()->forever('referral', $referral));
		}
		
        return $next($request);
    }
}
