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
class SReportMonitoringController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'SReportMonitoring.head_title','url'=>'admin/SReportMonitoring','active'=>true),
	);
	//列表界面
	public function viewList(Request $request){
		$data['head_title']=trans('SReportMonitoring.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('instructor.SReportMonitoringList', $data);
	}
	//获取报告列表数据
	public function getList(Request $request){
		$limit=$request->input('limit')?(int)$request->input('limit'):10;
		$reports=StarReport::leftjoin('students as s','s.id','=','star_report.student_id')
				->leftjoin('users as u','u.id','=','star_report.created_by')
				->leftjoin('star_account as sa','sa.asign_to','=','s.id')
				->where(function($where) use ($request){
					if($request->input('grade')){
						$where->where(['s.grade'=>$request->input('grade')]);
					}
					if($request->input('school_name')){
						$where->where('s.school_name','like','%'.$request->input('school_name').'%');
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
					if(in_array($request->input('report_type'),[0,1])){
						$where->where(['star_report.report_type'=>$request->input('report_type')]);
					}
				})
				->orderBy('star_report.id','desc')
				->select([
						'star_report.*',
						'sa.star_account',
						's.name as student_name',
						's.nick_name as student_nickname',
						's.grade',
						'u.name as teacher',
						's.school_name',
				])
				->paginate($limit);
		return $reports;
	}
	//按条件打包下载符合条件的报告
	public function export(Request $request){
		$star_report=$this->starReport($request);
		$stage_report=$this->stageReport($request);
		ob_end_clean();
		Excel::create('报告信息'.date('Y-m-d',time()),function($excel) use ($star_report,$stage_report){
			$excel->sheet('star评测报告', function($sheet) use ($star_report){
				$sheet->rows($star_report);
			});
			$excel->sheet('阶段性报告', function($sheet) use ($stage_report){
				$sheet->rows($stage_report);
			});
		})->store('xls')->export('xls');
	}
	//star评测报告
	private function starReport($request){
		$reports=StarReport::leftjoin('students as s','s.id','=','star_report.student_id')
		->leftjoin('star_account as sa','sa.asign_to','=','s.id')
		->where(function($where) use ($request){
			if($request->input('grade')){
				$where->where(['s.grade'=>$request->input('grade')]);
			}
			if($request->input('school_name')){
				$where->where('s.school_name','like','%'.$request->input('school_name').'%');
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
			$where->where(['star_report.report_type'=>0]);
		})
		->orderBy('star_report.id','desc')
		->select([
				'star_report.id',
				's.name as student_name',
				's.nick_name as student_nickname',
				'sa.star_account',
				's.grade',
				's.school_name',
				'star_report.test_date',
				'star_report.time_used',
				'star_report.ss',
				'star_report.pr',
				'star_report.estor',
				'star_report.ge',
				'star_report.irl',
				'star_report.zpd',
				'star_report.created_at',
		])
		->get()
		->toArray();
		$title=array('报告序号','学生姓名','学生昵称','star账号','年级','学校','测试时间','测试用时','SS','PR','EST.OR','GE','IRL','ZPD','报告创建时间');
		return collect($reports)->prepend($title);
	}
	//阶段性报告
	private function stageReport($request){
		$reports=StarReport::leftjoin('students as s','s.id','=','star_report.student_id')
		->leftjoin('star_account as sa','sa.asign_to','=','s.id')
		->where(function($where) use ($request){
			if($request->input('grade')){
				$where->where(['s.grade'=>$request->input('grade')]);
			}
			if($request->input('school_name')){
				$where->where('s.school_name','like','%'.$request->input('school_name').'%');
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
			$where->where(['star_report.report_type'=>1]);
		})
		->orderBy('star_report.id','desc')
		->select([
				'star_report.id',
				's.name as student_name',
				's.nick_name as student_nickname',
				'sa.star_account',
				's.grade',
				's.school_name',
				'star_report.created_at',
		])
		->get()
		->toArray();
		$title=array('报告序号','学生姓名','学生昵称','star账号','年级','学校','报告创建时间');
		return collect($reports)->prepend($title);
	}
}