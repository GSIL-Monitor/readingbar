<?php

namespace Readingbar\Teacher\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Teacher\Backend\Models\Students;
use Readingbar\Teacher\Backend\Models\StudentGroup;
use Auth;
use Validator;
use GuzzleHttp\json_encode;
use Symfony\Component\Debug\header;
use Monolog\Handler\error_log;
class ReadplanController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'readplan.head_title','url'=>'admin/readplan','active'=>true),
	);
   private $json=array();
   public function index(){
	   	echo "readplan";
   }
}
