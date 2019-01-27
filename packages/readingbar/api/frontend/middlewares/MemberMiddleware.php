<?php

namespace Readingbar\Api\Frontend\Middlewares;

use Closure;
use App;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Session;
class MemberMiddleware
{	
    public function handle($request, Closure $next)
    {	
    	if(!Auth::guard('member')->isLoged()){
    		if ($request->ajax() || $request->wantsJson()) {
    			$json=array(
    				'status'=>false,
    				'error'=>trans('errors.unlogin')
    			);
    			return response(json_encode($json), 200);
    		} else {
    			return redirect()->guest('/');
    		}
    	}
        return $next($request);
    }
}