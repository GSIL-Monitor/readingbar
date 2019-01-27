<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use \Illuminate\Session\Store as SessionStore ;
class LoginController extends FrontController
{
	/*登录界面*/
	public function index(Request $request,SessionStore $session){
		$data['head_title']='登录界面';
		if (session('theme')=='default') {
			abort(404);
		}
		if(session('error')){ 
			$data['error']=session('error');
			$data['login_type']=session('login_type');
		}
		if(session('success')){ 
			$data['success']=session('success');
		}
		if($request->input('intended')){
			$session->put('url.intended', $request->input('intended'));
		}
		return $this->view('login.login',$data);
	}
}
