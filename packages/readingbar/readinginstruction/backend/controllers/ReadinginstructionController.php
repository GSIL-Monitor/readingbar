<?php

namespace Readingbar\Readinginstruction\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Readinginstruction\Backend\Models\readinginstruction;
use Readingbar\Readinginstruction\Backend\Models\BookComment;
use Readingbar\Readinginstruction\Backend\Models\Students;
use Validator;
class ReadinginstructionController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'readinginstruction.head_title','url'=>'admin/readinginstruction','active'=>true),
	);
   public function index(){
	   	$data['head_title']=trans('readinginstruction.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
	   	$data['unfinishedApplies']=$this->unfinishedApplies();
	   	$data['unasignedStudents']=$this->unasignedStudents();
	   	$data['unansweredMessages']=$this->unansweredMessages();
	   	$data['untreatedComments']=$this->untreatedComments();
   		return view("Readingbar/readinginstruction/backend::readinginstruction",$data);
   }
   //待分配学生-数量
   public function unasignedStudents(){
   		$students=Students::whereNull('group_id')->count();
   		return $students;
   }
	//待处理的书评-数量
   public function untreatedComments(){
   		$books=BookComment::leftjoin('students','students.id','=','book_comment.commented_by')
   			->whereNull('checked_by')
   			->count();
   		return $books;
   }
   //待完成的申请-数量
   public function unfinishedApplies(){
   	  	return 0;
   }
   //待答复的消息-数量
   public function unansweredMessages(){
   		return 0;
   }
}
