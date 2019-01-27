<?php

namespace Readingbar\Bookmanager\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Bookmanager\Backend\Models\bookmanager;
use Validator;
use Readingbar\Bookmanager\Backend\Models\ReadPlan;
use Readingbar\Bookmanager\Backend\Models\ReadPlanDetail;
use Readingbar\Bookmanager\Backend\Models\BookStorage;
use Messages;
use Readingbar\Back\Models\Members;
use Readingbar\Back\Models\BookStorageLog;
use Readingbar\Back\Models\kdniaoExpressCode;
use Readingbar\Back\Models\KuaidiniaoExpress;
use Readingbar\Back\Controllers\Alidayu\AlidayuController;
use Readingbar\Back\Controllers\Messages\AlidayuSendController;
class BookLendByReadPlanController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'lendbook.head_title','url'=>'admin/lendbook','active'=>true),
	);
	private $json;
	private $errors;
   public function index(){
	   	$data['head_title']=trans('lendbook.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
	   	$data['express_companies'] = kdniaoExpressCode::get();
   		return view("Readingbar/bookmanager/backend::lendbook",$data);
   }
   //获取阅读计划列表-状态 1:用户已确认 ,2:已发货，3已收货
   public function getReadPlans(Request $request){
   	   $rps=ReadPlan::leftjoin('users','users.id','=','read_plan.created_by')
   	   		->leftjoin('students','students.id','=','read_plan.for')
   	   		->leftjoin('star_account','star_account.asign_to','=','students.id')
   	   		->leftjoin('members','students.parent_id','=','members.id')
   	   		->whereIn('read_plan.status',[1,2,3])
   	   		->orderBy('read_plan.created_at','desc');
   	   //页数 及每页显示记录的数量
   	   $page=$request->input('page')>1?(int)$request->input('page'):1;
   	   $limit=$request->input('limit')>0?(int)$request->input('limit'):10;
   	   $start=($page-1)*$limit;
   	   $total=$rps->count();
   	   $totalpages=ceil((float)$total/$limit);
   	   $rps=$rps->skip($start)->take($limit)->get(['read_plan.*','users.name as teacher_name','students.name as student_name','members.address','star_account.star_account']);
   	   //页数 及每页显示记录的数量
   	   foreach ($rps as $k=>$v){
   	   		$rps[$k]['details']=$this->getRPDs($v['id']);
   	   		$rps[$k]['status']=trans('lendbook.read_plan_status'.$v['status']);
   	   		$rps[$k]['express_1']=KuaidiniaoExpress::where(['plan_id'=>$v->id,'type'=>1])->first();
   	   		$rps[$k]['express_2']=KuaidiniaoExpress::where(['plan_id'=>$v->id,'type'=>2])->first();
   	   }
   	   $this->json=array('status'=>true,'total'=>$total,'total_pages'=>$totalpages,'current_page'=>$page,'data'=>$rps);
   	   $this->echoJson();
   }
   //获取阅读计划详情
   public function getRPDs($rid){
   	   $ds= ReadPlanDetail::leftjoin('read_plan','read_plan.id','=','read_plan_detail.plan_id')
   	   		->leftjoin('books','books.id','=','read_plan_detail.book_id')
   	   		->leftjoin('book_storage',function($join){
   	   			$join->on('book_storage.book_id', '=', 'read_plan_detail.book_id')
   	   			->on('book_storage.serial', '=', 'read_plan_detail.serial');
   	   		})
   	   		->where(['read_plan.id'=>$rid])
   	   		->whereIn('read_plan.status',[1,2,3])
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
   	   }
   	   return $ds;
   }
   //借出书籍
   public function lendBooks(Request $request){
   		$input=$request->all();
   		$rules=array(
   			'rpid'=>'exists:read_plan,id,status,1',
   		);
   		$messages=array('rpid.exists'=>'该计划不存在或者不可操作！');
   		$check=Validator::make($input,$rules,$messages);
   		if(!$check->fails()){
   			$ds=ReadPlanDetail::where(['read_plan_detail.plan_id'=>$input['rpid']])->get();
   			foreach($ds as $d){
   				BookStorageLog::create(
   						array(
   								'book_id'=>$d['book_id'],
   								'serial'=>$d['serial'],
   								'status'=>3,
   								'operate_by'=>Auth()->id(),
   								'plan_id'=>$input['rpid'],
   								'memo'=>'借出书籍'
   						)
   				);
   				//BookStorage::where(['book_id'=>$d['book_id'],'serial'=>$d['serial'],'status'=>4])->update(['status'=>3]);
   			}
   			ReadPlan::where(['id'=>$input['rpid']])->update(['status'=>3]);
   			//获取用户信息
   			$member=Members::leftjoin('students','students.parent_id','=','members.id')
   			->leftjoin('read_plan','read_plan.for','=','students.id')
   			->where(['read_plan.id'=>$input['rpid']])
   			->first();
   			//发送消息通知用户书籍已寄出
   			$rp=ReadPlan::where(['id'=>$input['rpid']])->first();
   			$alidayu = new AlidayuSendController();
   			if ($rp->type===1) { // 图书借阅
   				$alidayu->send('send_borrow_plan',$member->cellphone);
   				//Messages::sendMobile($member->cellphone,[],'SMS_113000004');
   			}else if ($rp->type===0) { // 定制阅读
   				$alidayu->send('send_read_plan',$member->cellphone);
   				//Messages::sendMobile($member->cellphone,[],'SMS_127160111');
   			}
   			$this->json=array('status'=>true,'success'=>'阅读计划已借出！');
   		}else{
   			$this->errors[]=$check->messages()->first();
   		}
   		$this->echoJson();
   }
   //记录运单号(借出)
   public function recordSCN(Request $request){
   		$check=Validator::make($request->all(),[
   			'rpid'=>'required|exists:read_plan,id',
   			'scn' =>'required',
   			's_reciever' =>'required'	
   		]);
   		if($check->passes()){
   			ReadPlan::where(['id'=>$request->input('rpid')])->update(['s_courier_number'=>$request->input('scn'),'s_reciever'=>$request->input('s_reciever')]);
   			return array('status'=>true,'success'=>'数据已保存！');
   		}else{
   			return array('status'=>false,'success'=>$check->errors()->first());
   		}
   }
   //记录运单号（回收）
   public function recordRCN(Request $request){
	   	$check=Validator::make($request->all(),[
	   			'rpid'=>'required|exists:read_plan,id',
	   			'rcn' =>'required',
	   			'r_sender' =>'required'
	   	]);
	   	if($check->passes()){
	   		ReadPlan::where(['id'=>$request->input('rpid')])->update(['r_courier_number'=>$request->input('rcn'),'r_sender'=>$request->input('r_sender')]);
	   		return array('status'=>true,'success'=>'数据已保存！');
	   	}else{
	   		return array('status'=>false,'success'=>$check->errors()->first());
	   	}
   }
   //退款回收书籍
   public function refund(Request $request){
   	$rpid=$request->input('rpid');
   	$input=array(
   			'id1'=>$rpid,
   			'id2'=>$rpid,
   			'id3'=>$rpid
   	);
   	$rules=array(
   			'id1'=>'exists:read_plan,id,status,1',
   			'id2'=>'exists:read_plan,id,status,2',
   			'id3'=>'exists:read_plan,id,status,3'
   	);
   	$messages=array(
   			'id1.exists'=>'该计划不存在或者不可操作！',
   			'id2.exists'=>'该计划不存在或者不可操作！',
   			'id3.exists'=>'该计划不存在或者不可操作！'
   	);
   	$check=Validator::make($input,$rules,$messages);
   	//dd(!$check->errors()->has('id1') || !$check->errors()->has('id2'));
   	if(!$check->errors()->has('id1') || !$check->errors()->has('id2') || !$check->errors()->has('id3')){
   		$ds=ReadPlanDetail::where(['read_plan_detail.plan_id'=>$rpid])->get();
   		foreach($ds as $d){
   			BookStorageLog::create(
   					array(
   							'book_id'=>$d['book_id'],
   							'serial'=>$d['serial'],
   							'status'=>1,
   							'operate_by'=>Auth()->id(),
   							'plan_id'=>$rpid,
   							'memo'=>'回收退款会员的阅读计划中的书籍'
   					)
   			);
   			//BookStorage::where(['book_id'=>$d['book_id'],'serial'=>$d['serial'],'status'=>3])->update(['status'=>1]);
   		}
   		ReadPlan::where(['id'=>$rpid])->update(['status'=>5]);
   		$this->json=array('status'=>true,'success'=>'书籍已回收！');
   	}else{
   		$this->errors[]=$check->messages()->first();
   	}
   	$this->echoJson();
   }
   //输出json
   private function echoJson(){
	   	if(count($this->errors)){
	   		$this->json=array('status'=>false,'error'=>$this->errors[0],'errors'=>$this->errors);
	   	}	
	   	echo json_encode($this->json);
   }
}
