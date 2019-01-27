<?php

namespace Superadmin\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
class CommonController extends Controller
{
	public function welcome(){
		$data=array();
		return view("superadmin/backend::welcome",$data);
	}
	public function no_permissions(){
		$data=array();
		return view("superadmin/backend::no_permissions",$data);
	}
	public function lang($lang){
		$languages=array('en','zh');
		if(!in_array($lang,$languages)){
			$lang="en";
		}
		session()->put('locale', $lang);
		App::setLocale($lang);
		return redirect()->back();
	}
}
