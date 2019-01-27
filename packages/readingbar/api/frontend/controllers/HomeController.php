<?php

namespace Readingbar\Api\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

class HomeController extends FrontController
{
	public function index(Request $request){
		
		$data['head_title']='蕊丁吧-首页';
		return $this->view('home.home', $data);
	}
}
