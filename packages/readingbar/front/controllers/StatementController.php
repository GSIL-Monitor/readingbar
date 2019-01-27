<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class StatementController extends FrontController
{
	/*用户隐私声明*/
	public function privacy(){
		$data['head_title']='用户隐私声明';
		return $this->view('statement.privacy', $data);
	}
}
