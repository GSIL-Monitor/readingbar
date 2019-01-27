<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Readingbar\Api\Frontend\Models\StarAccountAsign;
use Readingbar\Api\Frontend\Models\StarReport;
use Storage;
class StarController extends FrontController
{
	private $member=null;
	public function __construct(){
		$this->member=auth('member')->member();
	}
	/*star评测申请*/
	public function starApply(Request $request){
		$input=array(
			'student_id'=>$request->input('student_id'),
			'asign_to'=>$request->input('student_id')
		);
		$rules=array(
			'student_id'=>'required|exists:students,id,parent_id,'.$this->member->id,
			'asign_to'=>'required|unique:star_account_asign,asign_to'
		);
		$messages=array();
		$attributes=array();
		$check=Validator::make($input,$rules,$messages,$attributes);
		if($check->errors()->has('student_id')){
			$this->json=array('status'=>false,'error'=>'孩子不存在！');
		}else
		if($check->errors()->has('asign_to')){
			$this->json=array('status'=>false,'error'=>'已经申请过了，请耐心等待老师分配！');
		}
		if(!$this->json){
			$apply=array(
				'asign_to'=>$request->input('student_id')
			);
			StarAccountAsign::create($apply);
			$this->json=array('status'=>true,'success'=>'已经申请，请耐心等待老师分配！');
		}
		$this->echoJson();
	}
	/*获取star评测账号*/
	public function starAccount(Request $request){
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
			$account=StarAccountAsign::leftjoin('star_account','star_account.id','=','star_account_asign.account_id')
				->whereNotNull('star_account_asign.account_id')
				->first(['star_account','star_password']);
			if($account){
				$this->json=array('status'=>true,'success'=>'账号获取成功！','data'=>$account->toArray());
			}else{
				$this->json=array('status'=>false,'error'=>'账号还未分配！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'孩子不存在！');
		}
		$this->echoJson();
	}
	/*获取star评测结果*/
	public function starReport(Request $request){
		$rps=StarReport::leftjoin('students as s','s.id','=','star_report.student_id')
						->where(['s.parent_id'=>auth('member')->id(),'s.del'=>0])
						
						->where(function($where)use($request){
							if($request->input('report_type')!="" &&  in_array($request->input('report_type'),[0,1])){
								$where->where(['star_report.report_type'=>$request->input('report_type')]);
							}
							if($request->input('student_id')){
								$where->where(['s.id'=>$request->input('student_id')]);
							}
						})
						->select(['star_report.*','s.name'])
						->distinct()
						->orderBy('star_report.created_at','desc')
						->paginate((int)$request->input('limit')>0?(int)$request->input('limit'):10);
			foreach ($rps as $k=>$v){
				$rps[$k]['pdf_en']=url("api/member/children/star/readReport/".$v->student_id."/".$v->id."/en");
				$rps[$k]['pdf_zh']=url("api/member/children/star/readReport/".$v->student_id."/".$v->id."/zh");
				$rps[$k]['pdf_stage']=url("api/member/children/star/readReport/".$v->student_id."/".$v->id."/stage");
				$rps[$k]['dateline']=date('Y-m-d',strtotime($rps[$k]['created_at']));
				$rps[$k]['booklist']=url('member/children/starReport/'.$v->id.'/Booklist');
			}
			//dd($rps->toArray());
		return $rps;
	}
	/*查看报告*/
	public function readReport($sid,$rid,$type){
		$input=array(
				'student_id'=>$sid,
				'report_id'=>$rid,
				'type'=>$type,
		);
		$rules=array(
				'student_id'=>'required|exists:students,id,parent_id,'.$this->member->id,
				'report_id'=>'required|exists:star_report,id,student_id,'.$sid,
				'type'=>'required|in:en,zh,stage'
		);
		$messages=array();
		$attributes=array();
		$check=Validator::make($input,$rules,$messages,$attributes);
		if($check->passes()){
			$report=StarReport::where(['id'=>$rid])->first()->toArray();
			$exists = Storage::exists($report['pdf_'.$type]);
			if($exists){
				ob_clean();
				flush();
				return response()->download($report['pdf_'.$input['type']]);
			}else{
				echo "文件不存在！";
			}
		}else{
			if($check->errors()->has('student_id')){
				echo "孩子不存在！";
			}elseif($check->errors()->has('report_id')){
				echo "报告不存在！";
			}elseif($check->errors()->has('type')){
				echo $type."该类型的阅读报告不存在";
			}
			
		}
	}
}
