<?php

namespace Readingbar\Teacher\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Teacher\Backend\Models\StarAccount;
use Auth;
use Validator;
use GuzzleHttp\json_encode;
use Symfony\Component\Debug\header;
use Monolog\Handler\error_log;
use Readingbar\Api\Frontend\Models\StarAccountAsign;
use Readingbar\Api\Frontend\Models\Students;
class StarAccountController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'staraccount.head_title','url'=>'admin/teacher','active'=>true),
	);
   private $json=array();
   private $errors=array();
   public function index(){
	   	$data['head_title']=trans('staraccount.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		return view("Readingbar/teacher/backend::staraccount",$data);
   }
   //获取star账号列表
   public function accountsList(Request $request){
   		$teacher=Auth::user();
   		$r=StarAccount::leftjoin('users','users.id','=','star_account.created_by')
   		->where(['created_by'=>$teacher->id])
   		->where(function($where) use($request){
   			//条件
   			if($request->input('account')!=null){
   				$where->where('star_account','like','%'.$request->input('account').'%');
   			}
   			if($request->input('status')!=null){
   				$where->where('status','=',$request->input('status'));
   			}
   			if($request->input('grade')!=null){
   				$where->where('star_account.grade','=',$request->input('grade'));
   			}
   		})
   		->orderBy('star_account.id','desc')
   		->select([
   				'star_account.id',
   				'star_account.star_account',
   				'star_account.star_password',
   				'star_account.created_at',
   				'star_account.updated_at',
   				'star_account.status',
   				'star_account.grade',
   				'users.name as created_by'
   		])
   		->paginate($request->input('limit')>0?(int)$request->input('limit'):10);
   		$r->status = true;
   		return $r;
   }
   //创建新的star账号
   public function create(Request $request){
   		$teacher=Auth::user();
   		$sourceNumber = $ta_num=StarAccount::count()+100;
   		if($sourceNumber<1000){
   			$sourceNumber = substr(strval($sourceNumber+10000),1,4);
   		}
   		$acount=array(
   				'created_by'=>$teacher->id,
   				'star_account'=>'readingbar'.$sourceNumber,
   				'star_password'=>rand(100000,999999),
   				'status'=>-1
   		);
   		$check=Validator::make($acount,
   				[
   					'star_account'=>'unique:star_account,star_account'
   				]
   		);
   		if($check->passes()){
   			StarAccount::create($acount);
   			$this->json=array('status'=>true,'success'=>'创建成功！');
   		}else{
   			$this->json=array('status'=>false,'error'=>$acount['star_account'].'重复，创建失败！');
   		}
   		$this->echoJson();
   }
   //修改star账号的状态
   public function changeStatus(Request $request){
   		$teacher=Auth::user();
	   	$check=Validator::make($request->all(),
   			[
   				'account_id'=>'exists:star_account,id,created_by,'.$teacher->id,
	   			'status'=>'in:-1,0,1,2',
   			]
	   	);
	   	if(!$check->fails()){
	   		/*判断该账号是否可以修改状态*/
	   		$sa=StarAccount::leftjoin('star_account_asign','star_account_asign.account_id','=','star_account.id')
	   				->leftjoin('students','star_account_asign.asign_to','=','students.id')
	   				->where(['star_account.id'=>$request->input('account_id')])
	   				->first(['star_account.status','students.id as student_id']);
	   		if($sa->status==1 && Students::hasService($sa->student_id)){
	   			 $this->errors[]='该账号正在被付费用户使用中，状态不可修改！';
	   			 $this->echoJson();
	   			 exit;
	   		}
	   		StarAccount::where(['id'=>$request->input('account_id')])->update(['status'=>$request->input('status'),'asign_to'=>null,'asign_date'=>null,'notify_system'=>0,'notify_user'=>0]);
	   		$this->json=array('status'=>true,'success'=>'状态修改成功！');
	   	}else{
	   		if($check->errors->has('account_id')){
	   			$this->errors[]='账号不存在或您无权操作！';
	   		}
	   		if($check->errors->has('status')){
	   			$this->errors[]='无此状态！';
	   		}
	   	}
	   	$this->echoJson();
   }
   //修改star账号的年级
   public function changeGrade(Request $request){
	   	$teacher=Auth::user();
	   	$check=Validator::make($request->all(),
	   			[
	   					'account_id'=>'exists:star_account,id,created_by,'.$teacher->id,
	   					'grade'=>'in:k,1,2,3,4,5,6,7,8,9,10,11,12',
	   			]
	   	);
	   	if(!$check->fails()){
	   		StarAccount::where(['id'=>$request->input('account_id')])->update(['grade'=>$request->input('grade')]);
	   		$this->json=array('status'=>true,'success'=>'年级修改成功！');
	   	}else{
	   		if($check->errors->has('account_id')){
	   			$this->errors[]='账号不存在或您无权操作！';
	   		}
	   		if($check->errors->has('grade')){
	   			$this->errors[]='无此年级！';
	   		}
	   	}
	   	$this->echoJson();
   }
   //重置密码
   public function resetPassword(Request $request){
	   	$teacher=Auth::user();
	   	$check=Validator::make($request->all(),
	   			[
	   					'account_id'=>'exists:star_account,id,created_by,'.$teacher->id,
	   			]
	    );
	   	if(!$check->fails()){
	   		$password=rand(100000,999999);
	   		StarAccount::where(['id'=>$request->input('account_id')])->update(['star_password'=>$password,'notify_system'=>0,'notify_user'=>0]);
	   		$this->json=array('status'=>true,'success'=>'密码重置成功！');
	   	}else{
	   		if($check->errors()->has('account_id')){
	   			$this->errors[]='账号不存在或您无权操作！';
	   		}
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
