<?php

namespace Readingbar\Teacher\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Teacher\Backend\Models\StarAccountAsign;
use Readingbar\Teacher\Backend\Models\Students;
use Readingbar\Teacher\Backend\Models\BookComment;
use Auth;
use Validator;
use GuzzleHttp\json_encode;
use Symfony\Component\Debug\header;
use Monolog\Handler\error_log;
use DB;
class TeacherController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'teacher.head_title','url'=>'admin/teacher','active'=>true),
	);
   private $json=array();
   public function index(){
	   	$data['head_title']=trans('tstudents.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
	   	$data['unfinishedStarApplies']=$this->unfinishedStarApplies();
	   	$data['unfinishedReadPlans']=$this->unfinishedReadPlans();
	   	$data['unansweredMessages']=(int)session('BMessages')['unread'];
	   	$data['untreatedComments']=$this->untreatedComments();
   		return view("Readingbar/teacher/backend::teacher",$data);
   }
   //待完成的申请（申请star测评）-数量
   public function unfinishedStarApplies(){
   	$teacher=Auth::user();
   	$applies=\Readingbar\Back\Models\Students::leftjoin('student_group','students.group_id','=','student_group.id')
   		   								->leftjoin('star_account as sa','sa.asign_to','=','students.id')
   		   								->leftjoin('service_status as ss','ss.student_id','=','students.id')
   		   								->leftjoin('services as s','ss.service_id','=','s.id')
   		   								->where(['student_group.user_id'=>$teacher->id])
   		   								->where(['s.star_account_service'=>1])
   		   								->whereNull('sa.id')
   		   								->where('ss.expirated','>=',DB::raw('NOW()'))
   		   								->count();
   		return $applies;
   }
   //待制定的阅读计划-数量
   public function unfinishedReadPlans(){
   		$teacher=Auth::user();
   		if(Auth::user()->role==3){
   			$num=\Readingbar\Back\Models\Students::leftjoin('student_group','students.group_id','=','student_group.id')
   										->leftjoin('read_plan as rp','rp.for','=','students.id')
   		   								->leftjoin('service_status as ss','ss.student_id','=','students.id')
   		   								->leftjoin('services as s','ss.service_id','=','s.id')
   		   								->where(['student_group.user_id'=>$teacher->id])
   		   								->where(['s.read_plan_service'=>1,'rp.status'=>-1])
   		   								->where('ss.expirated','>=',DB::raw('NOW()'))
   		   								->count();
   			
   		}else{
   			$num=\Readingbar\Back\Models\Students::leftjoin('student_group','students.group_id','=','student_group.id')
   										->leftjoin('read_plan as rp','rp.for','=','students.id')
   		   								->leftjoin('service_status as ss','ss.student_id','=','students.id')
   		   								->leftjoin('services as s','ss.service_id','=','s.id')
   		   								->where(['s.read_plan_service'=>1,'rp.status'=>-1])
   		   								->where('ss.expirated','>=',DB::raw('NOW()'))
   		   								->count();
   		}
   		
   		return $num;
   }
   //待答复的消息-数量
   public function unansweredMessages(){
   		return 0;
   }
   //待处理的书评-数量
   public function untreatedComments(){
   		$teacher=Auth::user();
   		$books=BookComment::leftjoin('students','students.id','=','book_comment.commented_by')
   			->leftjoin('student_group','students.group_id','=','student_group.id')
   			->where(['student_group.user_id'=>$teacher->id])
   			->whereNull('checked_by')
   			->count();
   		return $books;
   }
   //获取当前老师名下学生购买产品的日期
   public function getBoughtInfo(Request $request){
   		$teacher=Auth::user();
   		$return = DB::table('students as s')
   						->crossjoin('orders as o','s.id','=','o.owner_id')
   						->leftjoin('products as p','p.id','=','o.product_id')
   						->leftjoin('members as m','m.id','=','s.parent_id')
   						->leftjoin('star_account as sa','sa.asign_to','=','s.id')
				   		->leftjoin('student_group','s.group_id','=','student_group.id')
				   		->where(function($where)use($teacher,$request){
				   			//检索当前账号是否是老师
				   			if($teacher->role==3){
				   				$where->where(['student_group.user_id'=>$teacher->id]);
				   			}
				   			//star账号
				   			if($request->input('type')=='star_account'){
				   				$where->where('sa.star_account','like','%'.$request->input('keyword').'%');
				   			}
				   			//家长
				   			if($request->input('type')=='member'){
				   				$where->where('m.nickname','like','%'.$request->input('keyword').'%');
				   			}
				   			//最近支付期限
				   			//echo 'date_sub(curdate(),interval '.($request->input('days')>0?$request->input('days'):7).' day)';exit;
				   			$where->where('o.completed_at','>',DB::raw('date_sub(curdate(),interval '.($request->input('days')>0?$request->input('days'):7).' day)'));

				   		})
				   		->orderBy('o.completed_at','desc')
				   		->select([
				   				'p.product_name',
				   				's.name as student_name',
				   				's.nick_name as student_nickname',
				   				'sa.star_account',
				   				'o.completed_at',
				   				'm.nickname as parent'
				   		])
				   		->paginate($request->input("limit")>0?$request->input("limit"):10);
   		return $return;
   }
}
