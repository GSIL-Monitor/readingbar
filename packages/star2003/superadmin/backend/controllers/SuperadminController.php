<?php

namespace Superadmin\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Superadmin\Backend\Models\Access;
use Validator;
class SuperadminController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'superadmin.head_title','url'=>'admin/access','active'=>true),
	);
   public function index(){
	   	$data['head_title']=trans('superadmin.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		return view("superadmin/backend::superadmin",$data);
   }
}
