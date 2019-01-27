<?php

namespace Readingbar\Front\Controllers\Activity;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;

class ThanksgivingController extends FrontController
{
	/*感恩节活动*/
	public function index(){
		$data['head_title']='感恩节活动';
		return $this->view('activity.thanksgiving',$data);
	}
}
