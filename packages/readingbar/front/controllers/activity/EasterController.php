<?php

namespace Readingbar\Front\Controllers\Activity;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;

class EasterController extends FrontController
{
	/*复活节活动*/
	public function index(){
		$data['head_title']='复活节活动';
		return $this->view('activity.easter',$data);
	}
}
