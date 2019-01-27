<?php

namespace Readingbar\Member\Frontend\Middlewares;

use Closure;
use App;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\json_encode;
class MemberMiddleware
{	
    public function handle($request, Closure $next)
    {	
    	if(!Auth::guard('member')->isLoged()){
    		if ($request->ajax() || $request->wantsJson()) {
    			$json=array(
    				'error'=>trans('member.member_unlogin')
    			);
    			return response(json_encode($json), 200);
    		} else {
    			return redirect()->guest('account/login');
    		}
    	}
        return $next($request);
    }
}