<?php

namespace Readingbar\Front\Middlewares;
use Readingbar\Api\Functions\ClientFunction;
use Closure;
use Readingbar\Api\Frontend\Models\AccessLog;

class AccessLogMiddleware
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
    	$log=array();
    	$log['uri']=$request->getUri();
    	//获取访问的浏览器信息
    	$log['HTTP_USER_AGENT']=$request->server('HTTP_USER_AGENT');
    	if(session('theme')){
    		$log['theme']=session('theme');
    	}
		if(auth('member')->isLoged()){
			$log['member_id']=auth('member')->getId();
		}
		if(auth()->check()){
			$log['user_id']=auth()->id();
		}
		if($request->server('HTTP_ALI_CDN_REAL_IP')){
			//阿里云 cdn 获取真实IP
			$log['ip']=$request->server('HTTP_ALI_CDN_REAL_IP');
		}else{
			$log['ip']=$request->server('REMOTE_ADDR');
		}
		AccessLog::create($log);
        return $next($request);
    }
}
