<?php
namespace Readingbar\Back\Controllers\Instructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Auth;
use Validator;
use Readingbar\Back\Models\STSessions;
use Readingbar\Back\Models\Services;
use Readingbar\Back\Models\Users;
use DB;
use Readingbar\Back\Models\ServiceStatus;
class STSessionsMonitoringController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'STSessionsMonitoring.head_title','url'=>'admin/STSessionsMonitoring','active'=>true),
	);
	private $types=[];
	public function __construct(){
		$this->types=trans('tstudents.session_types');
	}
	//列表界面
	public function viewList(Request $request){
		$data['head_title']=trans('STSessionsMonitoring.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['sessions']=$this->getList($request)->toJson();
		$data['teachers']=Users::where(['role'=>3])->get(['id','name'])->toJson();
		$data['types']=collect($this->types)->toJson();
		$data['services']=Services::get(['id','service_name'])->toJson();
		return $this->view('instructor.STSessionsMonitoringList', $data);
	}
	//获取列表数据
	public function getList(Request $request){
		$services_ids = ServiceStatus::where(function($where) use($request){
			
		});
		$sessions=STSessions::crossJoin('students as s','s.id','=','st_sessions.student_id')
					->crossJoin('student_group as sg','sg.id','=','s.group_id')
					->crossJoin('star_account as sa','sa.asign_to','=','s.id')
					->crossJoin('users as u','u.id','=','sg.user_id')
					->whereIn('st_sessions.student_id',function ($query) use ($request){
						$query->from('service_status')
							->where(function($where) use($request){
								if($request->input('service_id')){
									$where->where(['service_id'=>$request->input('service_id')])
									->where('expirated','>',DB::raw('NOW()'));
								}
							})
							->select('student_id');
					})
					->where(function($where)use($request){
						$check=validator::make($request->all(),[
								'from'=>'required|date',
								'to'=>'required|date',
						]);
						if($request->input('student_name')){
							$where->where(['s.name'=>$request->input('student_name')]);
						}
						if($request->input('student_nickname')){
							$where->where(['s.nick_name'=>$request->input('student_nickname')]);
						}
						if($request->input('star_account')){
							$where->where('sa.star_account','like','%'.$request->input('star_account').'%');
						}
						if($request->input('type')){
							$where->where(['st_sessions.type'=>$request->input('type')]);
						}
						if($request->input('teacher_id')){
							$where->where(['u.id'=>$request->input('teacher_id')]);
						}
						if(!$check->errors()->has('from')){
							$where->where('st_sessions.time','>=',$request->input('from'));
						}
						if(!$check->errors()->has('to')){
							$where->where('st_sessions.time','<=',DB::raw('DATE_ADD("'.$request->input('to').'",INTERVAL 1 DAY)'));
						}
					})
					->distinct()
					->select([
						'st_sessions.*',
						's.name as student_name',
						's.nick_name as student_nickname',
						'sa.star_account',
						'u.name as teacher_name'
					])
					->groupBy('st_sessions.id')
					->orderBy('st_sessions.id','desc')
					//->toSql();echo $sessions;exit;
					->paginate($request->input('limit')?(int)$request->input('limit'):10);
		foreach ($sessions as $v){
			$v['type']=isset($this->types[$v['type']])?$this->types[$v['type']]:'未知方式';
		}
		return $sessions;
	}
}