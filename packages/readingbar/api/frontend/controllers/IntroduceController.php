<?php

namespace Readingbar\Api\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class IntroduceController extends FrontController
{
	/*服务介绍*/
	public function service(){
		$data['head_title']='服务介绍界面';
		return $this->view('introduce.service',$data);
	}
}
