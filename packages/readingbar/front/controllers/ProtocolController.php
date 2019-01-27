<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProtocolController extends FrontController
{
	/*用户协议*/
	public function user(){
		$data['head_title']='用户协议';
		return $this->view('protocol.user', $data);
	}
	/*用户注册协议*/
	public function register(){
		$data['head_title']='用户注册协议';
		return $this->view('protocol.register', $data);
	}
}
