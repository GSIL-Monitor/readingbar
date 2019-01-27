<?php

namespace Readingbar\Teacher\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Teacher\Backend\Models\Students;
use Readingbar\Teacher\Backend\Models\StarReport;
use Auth;
use Validator;
use GuzzleHttp\json_encode;
use Symfony\Component\Debug\header;
use Monolog\Handler\error_log;
use Hamcrest\Arrays\IsArray;
use Messages;
use Readingbar\Back\Models\TimedTask;
use Readingbar\Back\Models\StarAccount;
class StarReportController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'starreport.head_title','url'=>'admin/teacher','active'=>true),
	);
   private $json=array();
   private $errors=array();
   private $inputErrors=array();
   public function index(Request $request){
	   	$data['head_title']=trans('starreport.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
	   	$data['student_name']=$request->input('student_name')?$request->input('student_name'):'';
   		return view("Readingbar/teacher/backend::starreport",$data);
   }
   //获取对应的学生列表
   public function getReports(Request $request){
   		$teacher=Auth::user();
   		$reports=new StarReport();
   		$reports=$reports->leftjoin("students","students.id","=","star_report.student_id");
   		$reports=$reports->leftjoin("student_group","students.group_id","=","student_group.id");
   		$reports=$reports->where(['student_group.user_id'=>$teacher->id]);
   		//条件
   		if($request->input('student_name')!=null){
   			$reports=$reports->where('students.name','like','%'.$request->input('student_name').'%');
   		}
   		//条件
   		//排序
   		if($request->input('order')!=null && in_array($request->input('order'),['id'])){
   			switch($request->input('order')){
   				default:$order='students.id';
   			}
   		}else{
   			$order='students.id';
   		}
   		if($request->input('sort')!=null && in_array($request->input('sort'),['asc','desc'])){
   			$sort=$request->input('sort');
   		}else{
   			$sort='asc';
   		}
   		$reports=$reports->orderby($order,$sort);
   		//排序
   		//页数 及每页显示记录的数量
   		$page=$request->input('page')>1?(int)$request->input('page'):1;
   		$limit=$request->input('limit')>0?(int)$request->input('limit'):10;
   		$start=($page-1)*$limit;
   		$total=$reports->count();
   		$totalpages=ceil((float)$total/$limit);
   		$reports=$reports->skip($start)->take($limit)->get(['star_report.*','students.name as student_name']);
   		//页数 及每页显示记录的数量
   		$this->json=array('status'=>true,'total'=>$total,'total_pages'=>$totalpages,'current_page'=>$page,'data'=>$reports);
   		$this->echoJson();
   }
   //新增report
   public function createReport(Request $request){
   		$teacher=Auth::user();
   		if($this->checkTeacherAndStudent($teacher->id,$request->input('student_id')) && $this->checkInput($request)){
   			$report=$request->all();
   			$report['created_by']=$teacher->id;
   			StarReport::create($report);
   			//消息通知
   			$conections=Students::leftjoin('members','students.parent_id','=','members.id')
   				->where(['students.id'=>$report['student_id']])
   				->first(['members.email as email','members.cellphone as sms'])
   				->toArray();
   			Messages::sendMessageForAllConections($conections,'Readingbar',array(),'starreport');
   			//消息通知
   			//定时任务-通知-未付款的学生
   				$student=Students::where(['id'=>$request->input('student_id')])->where('expiration_time','<',date('Y-m-d H:i:s',time()))->first();
   				if($student){
   					//2天后通知家长
   					$task=array(
   							'E-time'=>date('Y-m-d H:i:s',time()+60*60*24*2),
   							'action'=>'star_report_created_to_parent',
   							'data'  =>serialize(array(
		   							'student_id'	=>$student->id
		   					)),
   							'unique'=>md5('star_report_created_'.$student->id)
   					);
   					TimedTask::create($task);
   					//3天后通知老师
   					$task=array(
   							'E-time'=>date('Y-m-d 17:00:00',time()+60*60*24*3),
   							'action'=>'star_report_created_to_teacher',
   							'data'  =>serialize(array(
   									'student_id'	=>$student->id
   							 )),
   							'unique'=>md5('star_report_created_'.$student->id)
   					);
   					TimedTask::create($task);
   				}
   			//定时任务-通知-未付款的学生
   			$this->json=array('status'=>true,'success'=>'创建成功！');
   		}
   		if($this->inputErrors){
   			$this->json['view']='create';
   			$this->json['inputErrors']=$this->inputErrors;
   			return redirect('admin/starreport')->with($this->json);
   		}elseif($this->errors){
   			$this->json['view']='create';
   			$this->json['errors']=$this->errors;
   			return redirect('admin/starreport')->with($this->json);
   		}else{
   			return redirect('admin/starreport')->with($this->json);
   		}
   }
   //编辑report
   public function editReport(Request $request){
   		$teacher=Auth::user();
   		if($this->checkTeacherAndStudent($teacher->id,$request->input('student_id')) && $this->checkInput($request)){
   			$report=$request->all();
   			unset($report['student_name']);
   			StarReport::where(['id'=>$request->input('id'),'student_id'=>$request->input('student_id')])->update($report);
   			$this->json=array('status'=>true,'success'=>'更新成功！');
   		}
   		if($this->inputErrors){
   			$this->json['view']='edit';
   			$this->json['inputErrors']=$this->inputErrors;
   			return redirect('admin/starreport')->with($this->json);
   		}elseif($this->errors){
   			$this->json['view']='edit';
   			$this->json['errors']=$this->errors;
   			return redirect('admin/starreport')->with($this->json);
   		}else{
   			return redirect('admin/starreport')->with($this->json);
   		}
   		
   }
   //删除report
   public function deleteReport(Request $request){
   		$teacher=Auth::user();
   		$r=StarReport::leftjoin('students','students.id','=','star_report.student_id')
	   			->leftjoin('student_group','student_group.id','=','students.group_id')
	   			->where(['star_report.id'=>$request->input('report_id'),'student_group.user_id'=>$teacher->id])
	   			->delete();
   		if($r){
   			$this->json=array('status'=>true,'success'=>'数据已删除！');
   		}else{
   			$this->errors[]='数据删除失败！';
   		}
   		$this->echoJson();
   }
   //判断老师与学生的关系
   private function checkTeacherAndStudent($tid,$sid){
   		$r=Students::leftjoin("student_group","students.group_id","=","student_group.id")
   			->where(['student_group.user_id'=>$tid,'students.id'=>$sid])
   			->count();
   		if($r){
   			return true;
   		}else{
   			$this->errors[]="请选择您的学生！";
   			return false;
   		}
   }
   //获取老师相关学生数据
   public function getStudents(Request $request){
   		$teacher=Auth::user();
   		$students=Students::leftjoin("student_group","students.group_id","=","student_group.id")
   			->where(['student_group.user_id'=>$teacher->id])
   			->get(['students.id as student_id','students.name as student_name'])->toArray();
   		$this->json=array('status'=>true,'success'=>'数据获取成功！','data'=>$students);
   		$this->echoJson();
   }
   //校验录入内容
   private function checkInput($request){
   		$rules=[
   			'student_id'=>'required|exists:students,id',
   			'test_date'=>'required',
   			'report_id'=>'required',
   			'time_used'=>'required',
   			'grade'=>'required',
   			'ge'=>'required',
   			'ss'=>'required',
   			'pr'=>'required',
   			'estor'=>'required',
   			'irl'=>'required',
   			'zpd'=>'required',
   			'wks'=>'required',
   			'cscm'=>'required',
   			'alt'=>'required',
   			'uac'=>'required',
   			'aaet'=>'required',
   			//'result'=>'required',
   			//'explain'=>'required',
   			'pdf_en'=>'required',
   			'pdf_zh'=>'required',
   		];
   		$check=Validator::make($request->all(),$rules);
   		if($check->fails()){
   			foreach ($rules as $k=>$v){
   				if($check->errors()->has($k)){
   					switch($k){
   						case 'student_id':$this->inputErrors['student_id']='学生不存在！';break;
   						default:$this->inputErrors[$k]='不能为空！';
   					}
   				}
   			}
   			return false;
   		}else{
   			return true;
   		}
   }
   //输出json
   private function echoJson(){
   		if(count($this->errors)){
   			foreach ($this->errors as $v){
   				$error=$v;
   				break;
   			}
   			$this->json=array('status'=>false,'error'=>$error,'errors'=>$this->errors);
   		}
   		if(count($this->inputErrors)){
   			foreach ($this->inputErrors as $v){
   				$error=$v;
   				break;
   			}
   			$this->json=array('status'=>false,'inputErrors'=>$this->inputErrors);
   		}
   		echo json_encode($this->json);
   }
}
