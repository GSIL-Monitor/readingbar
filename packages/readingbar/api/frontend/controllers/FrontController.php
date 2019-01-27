<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class FrontController extends Controller
{
	public $json=array();
	public $debug=false;
	public function echoJson(){
		if($this->debug){
			header("Content-type: text/html; charset=utf-8");
			var_dump($this->json);
		}else{
			echo json_encode($this->json);
		}
	}
}
