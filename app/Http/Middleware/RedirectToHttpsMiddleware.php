<?php

namespace App\Http\Middleware;

use Closure;

class RedirectToHttpsMiddleware
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
		
		if(config('app.env')!='local' && $request->secure()==false){
			return redirect()->secure($request->getRequestUri());
		}
		
        return $next($request);
    }
}
