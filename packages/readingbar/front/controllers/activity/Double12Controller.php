<?php

namespace Readingbar\Front\Controllers\Activity;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;

class Double12Controller extends FrontController
{
	/*双12*/
	public function index(){
		$data['head_title']='双12';
		return $this->view('activity.double12',$data);
	}
}
