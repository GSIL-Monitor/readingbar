<?php

namespace Readingbar\Back\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class BackController extends Controller
{
	public $json=array();
	public function view($blade,$data){
		return view('back::'.$blade,$data);
	}
	public function echoJson(){
		return json_encode($this->json);
	}
}
