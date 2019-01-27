<?php

namespace Readingbar\Bookmanager\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Bookmanager\Backend\Models\bookmanager;
use Validator;
use Readingbar\Back\Models\ReadPlan;
use Readingbar\Back\Models\ReadPlanDetail;
use Readingbar\Bookmanager\Backend\Models\BookStorage;
use DB;
use Readingbar\Back\Models\BookStorageLog;
use Messages;
use Readingbar\Api\Functions\MemberFunction;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\KuaidiniaoExpress;
use Readingbar\Back\Models\kdniaoExpressCode;
use Readingbar\Back\Controllers\Messages\AlidayuSendController;
class BookRecoveryByReadPlanController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'recoverybook.head_title','url'=>'admin/lendbook','active'=>true),
	);
	private $json;
	private $errors;
   public function index(){
	   	$data['head_title']=trans('recoverybook.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
	   	$data['express_companies'] = kdniaoExpressCode::get();
   		return view("Readingbar/bookmanager/backend::recoverybook",$data);
   }
   //获取阅读计划列表-状态 4:已发回 ,5:已回收上架     借阅计划 3： 已借出
   public function getReadPlans(Request $request){
   	   $rps=ReadPlan::leftjoin('users','users.id','=','read_plan.created_by')
   	   		->leftjoin('students','students.id','=','read_plan.for')
   	   		->leftjoin('members','students.parent_id','=','members.id')
   	   		->leftjoin('star_account','star_account.asign_to','=','students.id')
   	   		->where(function($where){
   	   			$where->orwhereIn('read_plan.status',[4,5,6,7])->where(['type'=>0]);
   	   			$where->orwhere(function ($where) {
   	   				$where->whereIn('read_plan.status',[3,4,5,6,7])->whereIn('type',[1,2]);
   	   			});
   	   		})
   	   		->where(function($where) use($request){
   	   			if($request->input('name')){
   	   				$where->where('students.name','like','%'.$request->input('name').'%');
   	   			}
   	   			if($request->input('cellphone')){
   	   				$where->where('members.cellphone','=',$request->input('cellphone'));
   	   			}
   	   			if($request->input('email')){
   	   				$where->where('members.email','=',$request->input('email'));
   	   			}
   	   			if($request->input('star_account')){
   	   				$where->where('star_account.star_account','=','readingbar'.$request->input('star_account'));
   	   			}
   	   		})
   	   		->orderBy('read_plan.created_at','desc');;
   	   //页数 及每页显示记录的数量
   	   $page=$request->input('page')>1?(int)$request->input('page'):1;
   	   $limit=$request->input('limit')>0?(int)$request->input('limit'):10;
   	   $start=($page-1)*$limit;
   	   $total=$rps->count();
   	   $totalpages=ceil((float)$total/$limit);
   	 //dd($rps->toSql());
   	   $rps=$rps->skip($start)->take($limit)->get(['read_plan.*','users.name as teacher_name','students.name as student_name','members.address','star_account.star_account']);
   	   //页数 及每页显示记录的数量
   	   foreach ($rps as $k=>$v){
   	   		$rps[$k]['details']=$this->getRPDs($v);
   	   		$rps[$k]['express_1']=KuaidiniaoExpress::where(['plan_id'=>$v->id,'type'=>1])->first();
   	   		$rps[$k]['express_2']=KuaidiniaoExpress::where(['plan_id'=>$v->id,'type'=>2])->first();
   	   }
   	   $this->json=array('status'=>true,'total'=>$total,'total_pages'=>$totalpages,'current_page'=>$page,'data'=>$rps);
   	   $this->echoJson();
   }
   //获取阅读计划详情
   private function getRPDs($p){
   	   $ds= ReadPlanDetail::leftjoin('read_plan','read_plan.id','=','read_plan_detail.plan_id')
   	   		->leftjoin('books','books.id','=','read_plan_detail.book_id')
   	   		->leftjoin('book_storage',function($join){
   	   			$join->on('book_storage.book_id', '=', 'read_plan_detail.book_id')
   	   			->on('book_storage.serial', '=', 'read_plan_detail.serial');
   	   		})
   	   		->distinct()
   	   		->where(['read_plan.id'=>$p['id']])
   	   		->get(['read_plan_detail.*','books.book_name','books.ISBN as book_isbn','books.BL as book_bl','books.ARQuizNo as book_arquizno','book_storage.status as book_status']);
   	   foreach ($ds as $d){
   	   		$log = BookStorageLog::where(['book_id'=>$d->book_id,'serial'=>$d->serial,'plan_id'=>$d->plan_id])->orderBy('id','desc')->first();
   	   		if ($log) {
   	   			$d->status = $log->status;
   	   		}elseif($p->status == 5){
   	   			$d->status = 1;
   	   		}else{
   	   			$d->status = $d->book_status;
   	   		}
   	   		$d->refreshStatus = false;
   	   		$d->operation = $this->BsPRelationship($d);
   	   }
   	   return $ds;
   }
   /**
    *指定书籍 回收
    */
   public function recovery($did) {
   		$detail=ReadPlanDetail::where(['id'=>$did])->first();
   		if ($detail) {
   			if (!$this->BsPRelationship($detail)) {
   				return array('status'=>false,'message'=>'该计划与书籍不是最后关联！');
   			}
   			$plan = $detail->plan();
   			if ($this->checkReadPlan($plan)) {
   				if ($this->checkReadPlanDetail($detail)) {
   					BookStorageLog::create(
   							array(
   									'book_id'=>$detail['book_id'],
   									'serial'=>$detail['serial'],
   									'status'=>1,
   									'operate_by'=>Auth()->id(),
   									'plan_id'=>$detail->plan_id,
   									'memo'=>'过期书籍或已发回的书籍回收'
   							)
   					);
   					return array('status'=>true,'message'=>'已回收！','data'=>['plan_status'=>$this->completeReadPlan($plan)]);
   				} else {
   					return array('status'=>false,'message'=>'书籍已回收！');
   				}
   			} else {
	   			return array('status'=>false,'message'=>'书籍不可回收！');
	   		}
   		} else {
   			return array('status'=>false,'message'=>'数据不存在！');
   		}
	   
   }
   /**
    * 指定书籍报损
    */
   public function loss($did) {
   	    $detail=ReadPlanDetail::where(['id'=>$did])->first();
   		if ($detail) {
   			if (!$this->BsPRelationship($detail)) {
   				return array('status'=>false,'message'=>'该计划与书籍不是最后关联！');
   			}
   			$plan = $detail->plan();
   			if ($this->checkReadPlan($plan)) {
   				if ($this->checkReadPlanDetail($detail)) {
	   				BookStorageLog::create(
	   						array(
	   								'book_id'=>$detail['book_id'],
	   								'serial'=>$detail['serial'],
	   								'status'=>5,
	   								'operate_by'=>Auth()->id(),
	   								'plan_id'=>$detail->plan_id,
	   								'memo'=>'书籍已破损'
	   						)
	   				);
	   				return array('status'=>true,'message'=>'已报损！','data'=>['plan_status'=>$this->completeReadPlan($plan)]);
   				} else {
   					return array('status'=>false,'message'=>'书籍已报损！');
   				}
   			} else {
	   			return array('status'=>false,'message'=>'书籍不可报损！');
	   		}
   		} else {
   			return array('status'=>false,'message'=>'数据不存在！');
   		}
   }
   /**
    * 指定书籍 未归还
    */
   public function notReturned($did) {
   	$detail=ReadPlanDetail::where(['id'=>$did])->first();
   	if ($detail) {
   		if (!$this->BsPRelationship($detail)) {
   			return array('status'=>false,'message'=>'该计划与书籍不是最后关联！');
   		}
   		$plan = $detail->plan();
   		if ($this->checkReadPlan($plan)) {
   			if ($this->checkReadPlanDetail($detail)) {
   				BookStorageLog::create(
   						array(
   								'book_id'=>$detail['book_id'],
   								'serial'=>$detail['serial'],
   								'status'=>6,
   								'operate_by'=>Auth()->id(),
   								'plan_id'=>$detail->plan_id,
   								'memo'=>'书籍未归还'
   						)
   				);
   				return array('status'=>true,'message'=>'已报损！','data'=>['plan_status'=>$this->completeReadPlan($plan)]);
   			} else {
   				return array('status'=>false,'message'=>'书籍未归还！');
   			}
   		} else {
   			return array('status'=>false,'message'=>'书籍不可修改"未归还"状态！');
   		}
   	} else {
   		return array('status'=>false,'message'=>'数据不存在！');
   	}
   }
   /**
    * 校验计划是否可回收/报损/未归还
    */
   private function checkReadPlan($plan) {
   	 	if ($plan->type == 1 || $plan->type == 2) {
   	 		return in_array($plan->status,[3,4,6,7]);
   	 	} else {
   	 		return in_array($plan->status,[4,6,7]);
   	 	}
   }
   /**
    * 校验回收和报损的书籍状态
    */
   private function checkReadPlanDetail($detail) {
	   	$book = $detail->book();
	   	if ($book && in_array($book->status,[3])) {
	   		return true;
	   	} else {
	   		return false;
	   	}
   }
   /**
    *  计划与书籍状态的关联性
    */
   private function BsPRelationship ($detail) {
   	  $log = BookStorageLog::where(['book_id'=>$detail['book_id'],'serial'=>$detail['serial']])
	   	  	->orderBy('id','desc')
	   	  	->first();
   	  if ($log && $log->plan_id == $detail->plan_id) {
   	  	return true;
   	  }else{
   	  	return false;
   	  }
   }
   /**
    * 校验计划书籍是否已全部回收或报损->改变状态
    */
   private function completeReadPlan($plan) {
   	 if ($plan->status != 5) {
   	 	if ($plan->booksCount(3) == 0) {
   	 		if ($plan->booksCount(5)>0 || $plan->booksCount(6)>0) {
   	 			ReadPlan::where(['id'=>$plan->id])->update(['status'=>7]);
   	 		}else{
   	 			ReadPlan::where(['id'=>$plan->id])->update(['status'=>5]);
   	 		}
   	 		// 发送短信
   	 		$cellphone = Students::where(['id'=>$plan->for])->first()->parent()->cellphone;
   	 		$alidayu = new AlidayuSendController();
   	 		switch($plan->type){
   	 			case 0: // 定制
   	 				$alidayu->send('recovery_read_plan',$cellphone);
   	 				break;
   	 			case 1: // 借阅
   	 				$alidayu->send('recovery_borrow_plan',$cellphone);
   	 				break;
   	 		}
   	 		return true;
   	 	} else {
   	 		if ($plan->status != 7) {
   	 			ReadPlan::where(['id'=>$plan->id])->update(['status'=>7]);
   	 			return true;
   	 		} else {
   	 			return false;
   	 		}
   	 	}
   	 } else {
   	 	return false;
   	 }
   }
   //输出json
   private function echoJson(){
	   	if(count($this->errors)){
	   		$this->json=array('status'=>false,'error'=>$this->errors[0],'errors'=>$this->errors);
	   	}	
	   	echo json_encode($this->json);
   }
}
