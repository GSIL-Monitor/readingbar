<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class RegisterController extends FrontController
{
	/*注册界面*/
	public function index(Request $request){
		$data['head_title']='注册界面';
		if (session('theme')=='default') {
			abort(404);
		}
		return $this->view('register.register',$data);
	}
}
