<?php

namespace Readingbar\Front\Controllers\Activity;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;

class FiftyFamousWritersController extends FrontController
{
	/*双12*/
	public function index(){
		$data['head_title']='50位世界知名童书作家';
		return $this->view('activity.FiftyFamousWriters',$data);
	}
}
