<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class AboutController extends FrontController
{
	/*关于我们*/
	public function us(){
		$data['head_title']='关于我们';
		return $this->view('about.us', $data);
	}
}
