<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class RecruitController extends FrontController
{
	/*招聘界面*/
	public function index(Request $request){
		$data['head_title']='招聘界面';
		return $this->view('recruit.recruit',$data);
	}
}
