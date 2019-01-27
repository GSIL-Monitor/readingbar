<?php

namespace Readingbar\Back\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Models\StarAccount;
use Readingbar\Back\Models\StarAccountAsign;
use Readingbar\Back\Models\StudentGroup;
use Auth;
use Validator;
use GuzzleHttp\json_encode;
use Symfony\Component\Debug\header;
use Monolog\Handler\error_log;
use Messages;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Controllers\BackController;
class StarAccountAsignController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'staraccountasign.head_title','url'=>'admin/teacher','active'=>true),
	);
   private $errors=array();
   public function index(){
	   	$data['head_title']=trans('staraccountasign.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		return $this->view("teacher.staraccountasign",$data);
   }
   //获取当前用户所分配学生的star评测申请列表
   public function appliesList(Request $request){
   		$teacher=Auth::user();
   		$applies=new Students();
   		$applies=$applies->leftjoin('student_group','student_group.id','=','students.group_id');
   		$applies=$applies->leftjoin('users','student_group.user_id','=','users.id');
   		$applies=$applies->leftjoin('star_account','star_account.asign_to','=','students.id');
   		$applies=$applies->where(['student_group.user_id'=>$teacher->id]);
   		//条件
   		if($request->input('student_name')!=null){
   			$applies=$applies->where('students.name','like','%'.$request->input('student_name').'%');
   		}
   		//排序
   		if($request->input('order')!=null && in_array($request->input('order'),['id'])){
   			switch($request->input('order')){
   				default:$order='star_account.created_by';
   			}
   		}else{
   			$order='star_account.created_by';
   		}
   		if($request->input('sort')!=null && in_array($request->input('sort'),['asc','desc'])){
   			$sort=$request->input('sort');
   		}else{
   			$sort='desc';
   		}
   		$applies=$applies->orderby($order,$sort);
   		//排序
   		//页数 及每页显示记录的数量
   		$page=$request->input('page')>1?(int)$request->input('page'):1;
   		$limit=$request->input('limit')>0?(int)$request->input('limit'):10;
   		$start=($page-1)*$limit;
   		$total=$applies->count();
   		$totalpages=ceil((float)$total/$limit);
   		$cloumns=[
   			'students.id',
	   		'star_account.star_account',
	   		'star_account.star_password',
   			'star_account.notify_system',
   			'star_account.notify_user',
	   		'students.id as student_id',
	   		'star_account.asign_date',
	   		'users.name as teacher_name',
	   		'students.name as student_name',
   			'students.nick_name as student_nickname',
   			'students.grade'
	    ];
   		$applies=$applies->skip($start)->take($limit)->get($cloumns);
   		//页数 及每页显示记录的数量
   		$this->json=array('status'=>true,'total'=>$total,'total_pages'=>$totalpages,'current_page'=>$page,'data'=>$applies);
   		$this->echoJson();
   }
   //获取当前用户所建立的star评测账号（账号状态0）
   public function starAccountsOfTeacher(Request $request){
   		$teacher=Auth::user();
   		$where=array(
   			'created_by'=>$teacher->id,
   			'status'=>0
   		);
   		$accounts=StarAccount::where($where)->get(['id','star_account','grade']);
   		$this->json=array('status'=>true,'data'=>$accounts);
   		$this->echoJson();
   }
   //分配学生账号-改变账号状态
   public function asign(Request $request){
   		$teacher=Auth::user();
   		
   		$check=Validator::make(
   			[
   				'student_id'=>$request->input('student_id'),
   				'account_id'=>$request->input('account_id')
	   		],[
	   			'student_id'=>'exists:students,id',
   				'account_id'=>'exists:star_account,id,status,0,created_by,'.$teacher->id,
	   		]
   		);
   		if(!$check->fails()){
   			//校验老师是否有对该学生分配账号的权限
   			$sg=StudentGroup::leftjoin('students','students.group_id','=','student_group.id')
   				->where(['students.id'=>$request->input('student_id'),'student_group.user_id'=>$teacher->id])
   				->first();
   			if($sg){
   				StarAccount::where(['asign_to'=>$request->input('student_id')])->update(['status'=>0,'asign_to'=>null,'asign_date'=>null,'notify_system'=>0,'notify_user'=>0]);
   				StarAccount::where(['id'=>$request->input('account_id')])->update(['status'=>1,'asign_to'=>$request->input('student_id'),'asign_date'=>date('Y-m-d H:i:s')]);
   				$this->json=array('status'=>true,'success'=>'账号已分配！');
   			}else{
   				$this->errors[]='您无权为该学生分配账号！';
   			}
   		}else{
   			if($check->errors()->has('student_id')){
   				$this->errors[]='学生不存在';
   			}
   			if($check->errors()->has('account_id')){
   				$this->errors[]='分配的账号不可用！';
   			}
   		}
   		$this->echoJson();
   }
   //发送消息通知家长
   public function informParents(Request $request){
	   	$teacher=Auth::user();
	   	 
	   	$check=Validator::make(
	   			[
	   					'student_id'=>$request->input('student_id')
	   			],[
	   					'student_id'=>'exists:students,id'
	   			]
	   );
	   	if(!$check->fails()){
	   		//校验老师是否有对该学生分配账号的权限
	   		$sg=StudentGroup::leftjoin('students','students.group_id','=','student_group.id')
	   		->where(['students.id'=>$request->input('student_id'),'student_group.user_id'=>$teacher->id])
	   		->first();
	   		if($sg){
	   			$sa=Students::leftjoin('star_account as sa','sa.asign_to','=','students.id')
	   				->leftjoin('members as m','m.id','=','students.parent_id')
	   				->where(['students.id'=>$request->input('student_id')])
	   				->whereNotNull('sa.id')
	   				->first([
	   					'students.name as student',
	   					'sa.star_account as account',
	   					'sa.star_password as password',
	   					'm.email',
	   					'm.cellphone'
	   				]);
	   			$services=Students::getStudentServices($request->input('student_id'));
	   			$sa['expiration_time']=$services->max('expirated');
	   			if($sa){
	   				$sa=$sa->toArray();
	   				$conections=array(
	   						'sms'=>$sa['cellphone'],
	   						'email'=>$sa['email']
	   				);
	   				Messages::sendMessageForAllConections($conections,"蕊丁吧",$sa,'starAsignBack');
	   				StarAccount::where(['asign_to'=>$request->input('student_id')])->update(['notify_user'=>1]);
	   				$this->json=array('status'=>true,'success'=>'通知已发送！');
	   			}else{
	   				$this->json=array('status'=>false,'error'=>'账号信息不存在！');
	   			}
   				
	   		}else{
	   			$this->errors[]='您无权操作该学生的相关信息！';
	   		}
	   	}else{
	   		if($check->errors()->has('student_id')){
	   			$this->errors[]='学生不存在';
	   		}
	   	}
	   	$this->echoJson();
   }
   //输出json
   public function echoJson(){
   		if(count($this->errors)){
   			$this->json=array('status'=>false,'error'=>$this->errors[0],'errors'=>$this->errors);
   		}
   		echo json_encode($this->json);
   }
}
