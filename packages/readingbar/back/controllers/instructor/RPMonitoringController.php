<?php
namespace Readingbar\Back\Controllers\Instructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Auth;
use Validator;
use Readingbar\Back\Models\StarReport;
use Excel;
use Readingbar\Back\Models\ReadPlan;
class RPMonitoringController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'RPMonitoring.head_title','url'=>'admin/RPMonitoring','active'=>true),
	);
	private $status=null;
	public function __construct(){
		$this->status = trans('readplan.status');
	}
	//列表界面
	public function viewList(Request $request){
		$data['head_title']=trans('RPMonitoring.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['readPlans']=$this->getList($request)->toJson();
		$data['status']=collect($this->status)->toJson();
		return $this->view('instructor.RPMonitoringList', $data);
	}
	//阅读计划详情界面
	public function viewDetail(Request $request){
		$data['head_title']=trans('RPMonitoring.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('instructor.RPMonitoringDetail', $data);
	}
	//获取阅读计划列表数据
	public function getList(Request $request){
		$readPlans=ReadPlan::leftjoin('students as s','s.id','=','read_plan.for')
				->leftjoin('star_account as sa','s.id','=','sa.asign_to')
				->leftjoin('student_group as sg','sg.id','=','s.group_id')
				->leftjoin('users as u','u.id','=','sg.user_id')
				->where(function($where)use($request){
					if($request->input('status') != null){
						$where->where(['read_plan.status'=>$request->input('status')]);
					}
					if($request->input('student_name')){
						$where->where('s.name','like','%'.$request->input('student_name').'%');
					}
					if($request->input('student_nickname')){
						$where->where('s.nick_name','like','%'.$request->input('student_nickname').'%');
					}
					if($request->input('star_account')){
						$where->where('sa.star_account','like','%'.$request->input('star_account').'%');
					}
				})
				->whereNotNull('s.id')
				->select([
						'read_plan.*',
						's.name as student_name',
						's.nick_name as student_nickname',
						'sa.star_account',
						'u.name as teacher_name'
				])
				->orderBy('read_plan.id','desc')
				->paginate($request->input('limit')?(int)$request->input('limit'):10);
		foreach ($readPlans as $k=>$v){
			$v['status']=$this->status[$v['status']];
		}
		return $readPlans;
	}
	
}