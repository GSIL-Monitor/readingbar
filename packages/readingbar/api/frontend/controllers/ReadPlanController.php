<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Readingbar\Api\Frontend\Models\ReadPlan;
use Readingbar\Back\Models\Students;
use Validator;
use Readingbar\Api\Frontend\Models\ReadPlanDetail;
use Readingbar\Api\Frontend\Models\Orders;
use Messages;
use Readingbar\Api\Frontend\Models\Messages as MessagesModel;
use Superadmin\Backend\Models\User;
use Readingbar\Back\Models\TimedTask;
use Readingbar\Back\Models\ServiceStatus;
class ReadPlanController extends FrontController
{
	private $member=null;
	public function __construct(){
		$this->member=auth('member')->member();
	}
	/*获取阅读计划*/
	public function plans(Request $request){
		$input=array(
				'student_id'=>$request->input('student_id')
		);
		$rules=array(
				'student_id'=>'required|exists:students,id,parent_id,'.$this->member->id
		);
		$messages=array();
		$attributes=array();
		$check=Validator::make($input,$rules,$messages,$attributes);
		if($check->passes()){
			$plans=ReadPlan::where(['for'=>$request->input('student_id'),'type'=>$request->input('type')]);
			if($request->input('page') && $request->input('page')>1){
				$page=(int)$request->input('page');
			}else{
				$page=1;
			}
			if($request->input('limit') && $request->input('limit')>0){
				$limit=(int)$request->input('limit');
			}else{
				$limit=10;
			}
			$total=$plans->count();
			$plans=$plans->paginate($limit);
			
			foreach ($plans as $k=>$p){
				$plans[$k]['details']=ReadPlanDetail::leftjoin('books','books.id','=','read_plan_detail.book_id')
													->where(['plan_id'=>$p['id']])
													->get(['books.book_name','read_plan_detail.created_at'])
													->toArray();
			}
			return $plans;
		}else{
			$this->json=array('status'=>false,'error'=>'孩子不存在！');
		}
		$this->echoJson();
	}
	/*获取计划详情*/
	public function detail(){
		
	}
	/*同意阅读计划*/
	public function agreePlan(Request $request){
		$inputs=$request->all();
		$rules=array(
				'plan_id'=>'required|exists:read_plan,id'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			//判断计划与会员的关系
			$r=ReadPlan::leftjoin('students','students.id','=','read_plan.for')
					->where(['students.parent_id'=>auth('member')->getId(),'read_plan.id'=>$inputs['plan_id']])
					->first();
			if($r){
				if($r->status>=1){
					$this->json=array('status'=>true,'success'=>'您已同意该阅读计划！');
				}else{
					ReadPlan::where(['id'=>$inputs['plan_id'],'status'=>0])->update(['status'=>1]);
					//通知图书管理员
					$message=array(
							'sendfrom'=>"system",
							'sendto'  =>4,
							'content' =>"编号".$inputs['plan_id']."的阅读计划已确认，请准备发书！"
					);
					MessagesModel::create($message);
					//取消定时任务
					TimedTask::where(['unique'=>md5('confirm_read_plan_'.$inputs['plan_id'])])->update(['status'=>1]);
					
					$this->json=array('status'=>true,'success'=>'您已同意该阅读计划！');
				}
			}else{
				$this->json=array('status'=>false,'error'=>'您无权操作该计划！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'计划不存在！');
		}
		$this->echoJson();
	}
	/*不同意阅读计划*/
	public function unagreePlan(Request $request){
		$inputs=$request->all();
		$rules=array(
				'plan_id'=>'required|exists:read_plan,id,status,0'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			//判断计划与会员的关系
			$r=ReadPlan::leftjoin('students','students.id','=','read_plan.for')
			->where(['students.parent_id'=>auth('member')->getId(),'read_plan.id'=>$inputs['plan_id']])
			->first();
			if($r){
				ReadPlan::where(['id'=>$inputs['plan_id'],'status'=>0])->update(['status'=>-1]);
				//通知老师
				$teacher=User::leftjoin('student_group','users.id','=','student_group.user_id')
	    			->leftjoin('students','students.group_id','=','student_group.id')
	    			->where(['students.id'=>$r->for])
	    			->first(['users.*']);
				$message=array(
						'sendfrom'=>"system",
						'sendto'  =>$teacher->id,
						'content' =>"编号".$inputs['plan_id']."的阅读计划已被用户退回，请重新制定！"
				);
				
				MessagesModel::create($message);
				
				//取消定时任务
				TimedTask::where(['unique'=>md5('confirm_read_plan_'.$inputs['plan_id'])])->update(['status'=>1]);
				
				$this->json=array('status'=>true,'success'=>'该计划已退回！');
			}else{
				$this->json=array('status'=>false,'error'=>'您无权操作该计划！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'计划不存在！');
		}
		$this->echoJson();
	}
	/*申请阅读计划*/
	public function applyReadPlan(Request $request){
		$input=array(
				'student_id'=>$request->input('student_id')
		);
		$rules=array(
				'student_id'=>'required|exists:students,id,parent_id,'.$this->member->id
		);
		$check=Validator::make($input,$rules);
		if($check->passes()){
			$student=Students::where(["id"=>$input['student_id']])->first();
			//学生是否在产品有效期内
			if(Students::hasService($input['student_id'])){
				//获取用户购买的最新订单
				$order=Orders::where(["owner_id"=>$input['student_id'],'status'=>1])->orderBy('id','desc')->first();
				if(!Students::hasReadPlanService($input['student_id'])){
					$this->json=array('status'=>false,'error'=>'您购买的产品无此服务！');
				}else
				if(ReadPlan::where(['for'=>$student->id,'status'=>-1,'type'=>0])->count()){
					$this->json=array('status'=>false,'error'=>'您已申请了阅读计划，请耐心等待！');
				}else
				if(ReadPlan::where(['for'=>$student->id,'status'=>0,'type'=>0])->count()){
					$this->json=array('status'=>false,'error'=>'您还有个阅读计划，等待您的确认！');
				}else
				if(ReadPlan::where(['for'=>$student->id,'status'=>1,'type'=>0])->count()){
					$this->json=array('status'=>false,'error'=>'您有个已确认的计划正整装待发！');
				}else
				if(ReadPlan::where(['for'=>$student->id,'status'=>2,'type'=>0])->count()){
					$this->json=array('status'=>false,'error'=>'您有个阅读计划尚未签收！');
				}else{
					//已收货状态的阅读计划
					if(ReadPlan::where(['for'=>$student->id,'status'=>3,'type'=>0])->count()){
						ReadPlan::where(['for'=>$student->id,'status'=>3])->update(['status'=>4]);
						//Messages::sendMessage($this->member->cellphone,"蕊丁吧",'','sms','returnBook');
					}
					$rpname='【'.date("Y",time())."】定制第".($student->countReadPlanCY()+1)."次";
					$rp=array(
							'plan_name'=>$rpname,
							'from'	   =>date("Y-m-d",time()),
							'to'	   =>date("Y-m-d",time()+60*60*24*30),
							'for'	   =>$student->id,
							'status'   =>-1
					);
					ReadPlan::create($rp);
					$this->json=array('status'=>true,'success'=>'阅读计划申请成功，请耐心等待！！');
				}
			}else{
				$this->json=array('status'=>false,'error'=>'您尚未购买产品或产品已过期请重新购买！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'孩子不存在！');
		}
		$this->echoJson();
	}
	/*还书*/
	public function returnBooks(Request $request){
		$input=array(
				'student_id'=>$request->input('student_id')
		);
		$rules=array(
				'student_id'=>'required|exists:students,id,parent_id,'.$this->member->id
		);
		$check=Validator::make($input,$rules);
		if($check->passes()){
			if(ReadPlan::where(['for'=>$request->input('student_id'),'status'=>3])->count()){
				ReadPlan::where(['for'=>$request->input('student_id'),'status'=>3])->update(['status'=>4]);
				$this->json=array('status'=>true,'success'=>'阅读计划还书已申请！');
			}else{
				$this->json=array('status'=>false,'error'=>'您没有需要还书的阅读计划！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'孩子不存在！');
		}
		$this->echoJson();
	}
}
