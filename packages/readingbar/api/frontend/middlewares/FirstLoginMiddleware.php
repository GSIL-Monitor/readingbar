<?php

namespace Readingbar\Api\Frontend\Middlewares;

use Closure;
use App;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\json_encode;
use Readingbar\Api\Frontend\Models\Students;
use Readingbar\Back\Controllers\Spoint\PointController;
use Symfony\Component\HttpFoundation\Session\Session;
class FirstLoginMiddleware
{	
    public function handle($request, Closure $next)
    {	
    	$session = new Session();
    	// 判断会话第一次登陆
    	if (auth('member')->check()) {
    		$a1 = !$session->get('first_login_user');
    		$a2 = $session->get('first_login_date') != date('Ymd',time());
    		$a3 = $session->get('first_login_user') != auth('member')->id();
    		if ($a1 || $a2 || $a3) {
    			$students=Students::where(['parent_id'=>auth('member')->id(),'del'=>0])->get();
	    		foreach($students as $s){
	    			PointController::increaceByRule([
	    					'rule'=>'login_every_day',
	    					'student_id'=>$s->id
	    			]);
	    		}
	    		$session->set('first_login_user', auth('member')->id());
	    		$session->set('first_login_date', date('Ymd',time()));
	    		$session->save();
    		}
    	}
        return $next($request);
    }
}