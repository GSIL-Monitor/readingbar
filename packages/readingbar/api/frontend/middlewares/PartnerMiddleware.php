<?php

namespace Readingbar\Api\Frontend\Middlewares;

use Closure;
use App;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Session;
class PartnerMiddleware
{	
    public function handle($request, Closure $next)
    {	
    	if($request->get('pcode')){
    		session(['pcode'=>$request->get('pcode')]);
    	}
        return $next($request);
    }
}