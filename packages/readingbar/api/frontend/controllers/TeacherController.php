<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Api\Frontend\Models\Members;

class TeacherController extends FrontController
{
	private $member=null;
	public function __construct(){
		$this->member=auth('member')->member;
	}
	/*获取会员关联的老师*/
	public function all(){
		if($this->member){
			$teachers=Members::leftjoin('students','students.parent_id','=','members.id')
				->leftjoin('student_group','students.group_id','=','student_group.id')
				->leftjoin('users','student_group.user_id','=','users.id')
				->where(['members.id'=>$this->member->id])
				->whereNotNull('students.group_id')
				->distinct()
				->get(['users.id','users.name'])
				->toArray();
			$this->json=array('status'=>true,'success'=>'数据获取成功！','data'=>$teachers);
		}else{
			$this->json=array('status'=>false,'error'=>'用户尚未登录！');
		}
		$this->echoJson();
	}
}
