<?php

namespace Readingbar\Front\Middlewares;
use Readingbar\Api\Functions\ClientFunction;
use Closure;

class ThemeMiddleware
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
    	if(!session('theme')){
    		if(ClientFunction::isMobile()){
    			session(['theme'=>'mobile']);
    		}else{
    			session(['theme'=>'default']);
    		}
    	}
		if($request->input('theme')){
			if(in_array($request->input('theme'),['default','mobile'])){
				session(['theme'=>$request->input('theme')]);
			}
			
		}
        return $next($request);
    }
}
