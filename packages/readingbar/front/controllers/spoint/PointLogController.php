<?php

namespace Readingbar\Front\Controllers\Spoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;
use DB;
use Validator;
use Readingbar\Back\Models\PointStatus;
use Readingbar\Back\Models\PointProduct;
use Readingbar\Back\Models\PointOrder;
use Readingbar\Back\Models\PointOrderProduct;
use Readingbar\Back\Models\Discount;
use Readingbar\Back\Models\PointLog;
use Readingbar\Back\Models\Students;
class PointLogController extends FrontController
{
	/*学生选择列表*/
	public function index(){
		$data['head_title']='我的蕊丁币';
		$data['students']=Students::leftjoin('s_point_status as sps','sps.student_id','=','students.id')
					->where(['students.parent_id'=>auth('member')->id(),'del'=>0])
					->get(['students.*','sps.point'])
					->each(function($student){
						$student->avatar=$student->avatar?url($student->avatar):url('files/avatar/default_avatar');
					});
		return $this->view("spoint.poingLogStudentList",$data);
	}
	/*学生积分日志*/
	public function logs($sid){
		if($sid){
			$data['head_title']='我的蕊丁币';
			$student=Students::leftjoin('s_point_status as sps','sps.student_id','=','students.id')->where(['students.id'=>$sid])->first(['students.*','sps.point']);
			$student->avatar=$student->avatar?url($student->avatar):url('files/avatar/default_avatar');
			$student->sex=$student->sex?'男':'女';
			$student->age=$this->birthday($student->dob);
			$student->services=Students::getStudentServices($student->id)->toArray();
			$student->point=(int)$student->point;
			$student->report_url=url('member/children/starReport/'.$student->id);
			$student->readplan_url=url('member/children/readplan/'.$student->id);
			$student->edit_url=url('member/children/readplan/'.$student->id);
			$data['student']=$student;
			//dd(Students::getStudentServices(330));
			return $this->view("spoint.poingLogList",$data);
		}else{
			return redirect('member');
		}
	}
	/*获取日志数据*/
	public function getLogs(Request $request){
		$logs=PointLog::leftjoin('students as s','s.id','=','s_point_log.student_id')
			->where(['s.id'=>$request->input('student_id'),'s.parent_id'=>auth('member')->getId(),'s_point_log.status'=>0])
			->orderBy('s_point_log.created_at','desc')
			->select(['s_point_log.*'])
			->paginate($request->input('limit')?$request->input('limit'):10)
			->toArray();
		foreach ($logs['data'] as $k=>$v){
			$logs['data'][$k]['created_at']=substr($v['created_at'],0,10);
		}
		return $logs;
	}
	//计算年龄
	private function birthday($birthday){
		$age = strtotime($birthday);
		if($age === false){
			return false;
		}
		list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age));
		$now = strtotime("now");
		list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now));
		$age = $y2 - $y1;
		if((int)($m2.$d2) < (int)($m1.$d1))
			$age -= 1;
			return $age;
	}
}
