<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class FrontController extends Controller
{
	public function view($blade,$data){
		return view('front::'.session('theme').'.'.$blade,$data);
	}
}
