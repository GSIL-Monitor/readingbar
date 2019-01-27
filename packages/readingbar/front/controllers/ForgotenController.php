<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class ForgotenController extends FrontController
{
	/*找回密码*/
	public function index(){
		$data['head_title']='找回密码';
		return $this->view('forgoten.forgoten', $data);
	}
}
