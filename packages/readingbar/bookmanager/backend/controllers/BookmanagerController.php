<?php

namespace Readingbar\Bookmanager\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Bookmanager\Backend\Models\bookmanager;
use Validator;
use Readingbar\Bookmanager\Backend\Models\BookStorage;
use Readingbar\Bookmanager\Backend\Models\ReadPlan;
class BookmanagerController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'bookmanager.head_title','url'=>'admin/bookmanager','active'=>true),
	);
   public function index(){
	   	$data['head_title']=trans('bookmanager.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
	   	$data['untreated']=$this->untreated();
	   	$data['toBeRecycled']=$this->toBeRecycled();
   		return view("Readingbar/bookmanager/backend::bookmanager",$data);
   }
   //待处理的阅读包裹
   public function untreated(){
   		return ReadPlan::where(['status'=>1])->count();
   }
   //待回收上架的包裹
   public function toBeRecycled(){
   		return ReadPlan::where(['status'=>4])->count();
   }
}
