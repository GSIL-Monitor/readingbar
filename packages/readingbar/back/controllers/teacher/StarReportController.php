<?php

namespace Readingbar\Back\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;

use Auth;
use Validator;
use Messages;
use Readingbar\Back\Models\TimedTask;
use Readingbar\Back\Models\StarAccount;
use Readingbar\Back\Models\StarReport;
use Readingbar\Back\Models\Students;
use Storage;
use Readingbar\Back\Models\Members;
use PhpOffice\PhpWord\TemplateProcessor;
use Readingbar\Back\Models\StarReportBooklist;
use Readingbar\Back\Controllers\Messages\AlidayuSendController;
class StarReportController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'starreport.head_title','url'=>'admin/teacher','active'=>true),
	);
  	/**
	 * star报告列表
	 */
	public function starReportList(Request $request){
		$data['head_title']=trans('starreport.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['student_name']=$request->input('student_name');
		return $this->view('teacher.starReportList', $data);
	}
	/**
	 * star报告表单
	 */
	public function starReportForm($id=null){
		$data['head_title']=trans('starreport.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['report_id']=$id;
		return $this->view('teacher.ReportForm', $data);
	}
	/**
	 * 获得所有报告信息
	 * @param Request $request
	 */
	public function getStarReports(Request $request){
		if((int)$request->input('limit')){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		
// 		$sr=StarReport::join('students as s','s.id','=','star_report.student_id')
// 			->join('members as m','m.id','=','s.parent_id')
// 			->join('student_group as sg','sg.id','=','s.group_id')
// 			->leftjoin('star_account as sa','sa.asign_to','=','s.id')
// 			->where(['sg.user_id'=>auth()->id()])
// 			->where('m.nickname','like','%'.$request->input('parent').'%')
// 			->where('m.email','like',$request->input('email').'%')
// 			->where('m.cellphone','like',$request->input('cellphone').'%')
// 			->where('s.name','like','%'.$request->input('student_name').'%')
// 			->where('s.nick_name','like','%'.$request->input('student_nickname').'%')
// 			->where('sa.star_account','like','%'.$request->input('star_account').'%')
// 			->orderBy('star_report.id','desc')
// 			->selectRaw('star_report.*,s.name as student_name,s.nick_name as student_nickname,m.nickname as parent,m.email,m.cellphone,sa.star_account')
// 			->paginate($limit);
		$sr = StarReport::join('students as s','s.id','=','star_report.student_id')
			->join('members as m','m.id','=','s.parent_id')
			->join('student_group as sg','sg.id','=','s.group_id')
			->leftjoin('star_account as sa','sa.asign_to','=','s.id')
			->where(['sg.user_id'=>auth()->id()])
			->where(function($where) use($request){
				if ($request->input('parent')) {
					$where->where('m.nickname','like','%'.$request->input('parent').'%');
				}
				if ($request->input('email')) {
					$where->where('m.email','like','%'.$request->input('email').'%');
				}
				if ($request->input('cellphone')) {
					$where->where('m.cellphone','like','%'.$request->input('cellphone').'%');
				}
				if ($request->input('student_name')) {
					$where->where('s.name','like','%'.$request->input('student_name').'%');
				}
				if ($request->input('student_nickname')) {
					$where->where('s.nick_name','like','%'.$request->input('student_nickname').'%');
				}
				if ($request->input('star_account')) {
					$where->where('sa.star_account','like','%'.$request->input('star_account').'%');
				}
			})
			->orderBy('star_report.id','desc')
			->selectRaw('star_report.*,s.name as student_name,s.nick_name as student_nickname,m.nickname as parent,m.email,m.cellphone,sa.star_account')
			->paginate($limit);
		foreach ($sr as $k=>$v){
			$sr[$k]['edit']=url('admin/teacher/starreport/'.$v['id'].'/form');
			$sr[$k]['booklist']=url('files/starReport/booklist/'.$v['id'].'.docx');
			$sr[$k]['en']=url('admin/teacher/starreport/downloadReport?student_id='.$v['student_id'].'&report_id='.$v['id'].'&type=en');
			$sr[$k]['zh']=url('admin/teacher/starreport/downloadReport?student_id='.$v['student_id'].'&report_id='.$v['id'].'&type=zh');
			$sr[$k]['stage']=url('admin/teacher/starreport/downloadReport?student_id='.$v['student_id'].'&report_id='.$v['id'].'&type=stage');
		}
		return $sr;
	}
	/**
	 * 获得单个报告信息
	 * @param Request $request
	 */
	public function getStarReport(Request $request){
		$sr=StarReport::join('students as s','s.id','=','star_report.student_id')
			->join('members as m','m.id','=','s.parent_id')
			->join('student_group as sg','sg.id','=','s.group_id')
			->where(['sg.user_id'=>auth()->id()])
			->where(['star_report.id'=>$request->input('report_id')])
			->first(['star_report.*','s.name as student_name','s.nick_name as student_nickname','m.nickname as parent','m.email','m.cellphone']);
		if ($sr) {
			$sr->booklist = StarReportBooklist::crossJoin('books','books.id','=','book_id')
										->where(['report_id'=>$request->input('report_id')])->get([
												'book_id as id',
												'book_name',
												'author',
												'BL',
												'ARQuizNo'
										]);
		}
		return $sr;
	}
	/**
	 * 新增报告
	 * @param Request $request
	 */
	public function createStarReport(Request $request){
		switch ($request->input('report_type')){
			case 0: 
				$rules=[
						'student_id'=>'required|exists:students,id',
						'star_account'=>'required',
						'test_date'=>'required',
						'time_used'=>'required',
						'grade'=>'required',
						'ge'=>'required',
						'lm'=>'required',
						'ss'=>'required',
						'pr'=>'required',
						'irl'=>'required',
						'zpd'=>'required',
// 						'wks'=>'required',
// 						'cscm'=>'required',
// 						'alt'=>'required',
// 						'uac'=>'required',
						'vo'=>'required',
						'ui'=>'required',
						'er'=>'required',
						'wr'=>'required',
						'pdf_en'=>'required|file|ext:pdf',
						//'pdf_zh'=>'required|file|ext:pdf',
						'report_type'=>'required|in:0,1',
				];
				$create=collect($request->all())->filter(function ($value, $key) {
				    return in_array($key,['student_id','star_account','test_date','time_used','grade','ss','pr','estor','ge','lm','irl','zpd','wks','cscm','alt','uac','vo','ui','er','wr','aaet','report_type']);
				})->all();
				$create['created_by']=auth()->id();
				$create['star_version']=2;
				$create['pdf_en']=$this->saveFile($request->file('pdf_en'), 'en');
				//$create['pdf_zh']=$this->saveFile($request->file('pdf_zh'), 'zh');
				break;
			case 1: 
				$rules=[
						'student_id'=>'required|exists:students,id',
						'report_type'=>'required|in:0,1',
						'memo'=>'required',
						'pdf_stage'=>'required|ext:pdf'
				];
				$create=collect($request->all())->filter(function ($value, $key) {
				    return in_array($key,['student_id','report_type','memo']);
				})->all();
				$create['created_by']=auth()->id();
				$create['pdf_stage']=$this->saveFile($request->file('pdf_stage'), 'stage');
				break;
			default:
					$rules=[
						'student_id'=>'required|exists:students,id',
						'report_type'=>'required|in:0,1'
					];
		}
		$check=Validator::make($request->all(),$rules);
		if ($check->passes()) {
			$report=StarReport::create($create);
			if ($report->report_type == 0) {
				$report->pdf_zh = $this->storeDocx($report->id);
				StarReport::where(['id'=>$report->id])->update($report->toArray());
				$this->saveBooklist($report->id,$request->input('booklist'));
			}
			$this->informParent($report);
			$json=array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$json=array('status'=>false,'errors'=>$check->errors()->toArray());
		}
		return $json;
	}
	/**
	 * 编辑报告
	 * @param Request $request
	 */
	public function editStarReport(Request $request){
		if($sr=StarReport::where(['id'=>$request->input('id')])->first()){
			switch ($request->input('report_type')){
				case 0: 
					$rules=[
							'student_id'=>'required|exists:students,id',
							'star_account'=>'required',
							'test_date'=>'required',
							'time_used'=>'required',
							'grade'=>'required',
							'ge'=>'required',
							'lm'=>'required',
							'ss'=>'required',
							'pr'=>'required',
							'irl'=>'required',
							'zpd'=>'required',
// 							'wks'=>'required',
// 							'cscm'=>'required',
// 							'alt'=>'required',
// 							'uac'=>'required',
							'vo'=>'required',
							'ui'=>'required',
							'er'=>'required',
							'wr'=>'required',
							'pdf_en'=>'file|ext:pdf',
							//'pdf_zh'=>'file|ext:pdf',
							'report_type'=>'required|in:0,1'
					];
					$update=collect($request->all())->filter(function ($value, $key) {
					    return in_array($key,['student_id','star_account','test_date','time_used','grade','ss','pr','estor','ge','lm','irl','zpd','wks','cscm','alt','uac','vo','ui','er','wr','aaet','report_type']);
					})->all();
					$update['created_by']=auth()->id();
					if ($request->file('pdf_en')) {
						$en=$this->saveFile($request->file('pdf_en'), 'en');
						if ($en) {
							$update['pdf_en']=$en;
						}
					}
					break;
				case 1: 
					$rules=[
							'student_id'=>'required|exists:students,id',
							'report_type'=>'required|in:0,1',
							'memo'=>'required',
							'pdf_stage'=>'ext:pdf'
					];
					$update=collect($request->all())->filter(function ($value, $key) {
					    return in_array($key,['student_id','report_type','memo']);
					})->all();
					$update['created_by']=auth()->id();
					if ($request->file('pdf_stage')) {
						$stage=$this->saveFile($request->file('pdf_stage'), 'stage');
						if ($stage) {
							$update['pdf_stage']=$stage;
						}
					}
					break;
				default:
						$rules=[
							'student_id'=>'required|exists:students,id',
							'report_type'=>'required|in:0,1'
						];
			}
			$check=Validator::make($request->all(),$rules);
			if ($check->passes()) {
				StarReport::where(['id'=>$request->input('id')])->update($update);
				$report=StarReport::where(['id'=>$request->input('id')])->first();
				if ($report->report_type == 0) {
					StarReport::where(['id'=>$request->input('id')])->update(['pdf_zh'=>$this->storeDocx($report->id)]);
					$this->saveBooklist($request->input('id'),$request->input('booklist'));
				}
				$this->informParent($report);
				$json=array('status'=>true,'success'=>'数据保存成功！');
			}else{
				$json=array('status'=>false,'errors'=>$check->errors()->toArray());
			}
		}else{
			$json=array('status'=>false,'error'=>'报告不存在！');
		}
		return $json;
	}
	/**
	 * 保存书单
	 * */
	public function saveBooklist($rid,$booklist){
		if ($booklist) {
			$result = StarReportBooklist::where(['report_id'=>$rid])->delete();
			foreach ($booklist as $bid) {
				$result = StarReportBooklist::create([
						'book_id'=>$bid,
						'report_id'=>$rid
				]);
			}
		}
		$data=StarReportBooklist::crossJoin('books','books.id','=','book_id')->where(['report_id'=>$rid])->get([
				'book_name',
				'author',
				'BL',
				'ARQuizNo',
				'reason'
		])->toArray();
		// 获取word模板
		$template = new TemplateProcessor(storage_path('templates/report_booklist_template.docx'));
		// phpword 内容标准化
		$patterns=["/\"/","/>/","/</","/&/"];
		$replaces=['&quot;','&gt;','&lt;','&amp;'];
		for($i = 0;$i<20;$i++){ // 模板内参数替换
			$template->setValue('book_name_'.$i, isset($data[$i])?preg_replace($patterns, $replaces, "【".$data[$i]['author']."】".$data[$i]['book_name']):'');
			$template->setValue('BL_'.$i, isset($data[$i])?preg_replace($patterns, $replaces,$data[$i]['BL']):'');
			$template->setValue('ARQuizNo_'.$i, isset($data[$i])?preg_replace($patterns, $replaces,$data[$i]['ARQuizNo']):'');
		}
		$dir='files/starReport/booklist/'.$rid.'.docx';
		$template->saveAs($dir);
	}
	/**
	 * 表单校验
	 * @param Request $request
	 */
	public function checkStarReport($inputs,$edit=false){
		switch(isset($inputs['report_type'])?$inputs['report_type']:null){
			case 0:
					  $rules=[
							'student_id'=>'required|exists:students,id',
							'test_date'=>'required',
							'time_used'=>'required',
							'grade'=>'required',
							'ge'=>'required',
							'ss'=>'required',
							'pr'=>'required',
							'estor'=>'required',
							'irl'=>'required',
							'zpd'=>'required',
							'wks'=>'required',
							'cscm'=>'required',
							'alt'=>'required',
							'uac'=>'required',
							'aaet'=>'required',
							'pdf_en'=>'required|ext:pdf',
							'pdf_zh'=>'required|ext:pdf',
							'report_type'=>'required|in:0,1',
					];
					break;
			case 1:  $rules=[
						'student_id'=>'required|exists:students,id',
						'report_type'=>'required|in:0,1',
						'memo'=>'required',
						'pdf_stage'=>'required|ext:pdf'
					];
					break;
			default:
				 	$rules=[
						'student_id'=>'required|exists:students,id',
						'report_type'=>'required|in:0,1',
					];
		}
		if($edit){
			$rules['id']='required|exists:star_report,id';
		}
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			return true;
		}else{
			return $check->errors();
		}
	}
	/**
	 * 文件保存
	 * @param Request $request
	 */
	public function saveFile($file,$lan,$filename=null){
		if($file && in_array($file->extension(),['pdf'])){
			if(!$filename){
				$pathinfo=pathinfo($file->getClientOriginalName());
				$filename=$pathinfo['filename'].'_'.$lan.'_'.date('YmdHis',time());
			}else{
				$pathinfo=pathinfo($filename);
				$filename=$pathinfo['filename'];
			}
			$dir='files/starReport/'.$filename.'.'.$file->extension();
			Storage::put(
					$dir,
						file_get_contents($file->getRealPath())
					);
			return $dir;
		}else{
			return false;
		}
	}
	/**
	 * 删除报告信息
	 * @param Request $request
	 */
	public function deleteStarReport(Request $request){
		if($request->input('selected') && is_array($request->input('selected'))){
			StarReport::whereIn('id',$request->input('selected'))->delete();
			$json=array('status'=>true,'success'=>'数据已删除！');
		}else{
			$json=array('status'=>false,'error'=>'请选择要删除的数据！');
		}
		return $json;
	}
	/**
	 * 消息通知
	 */
	public function informParent($report){
		if (isset($report->report_type) && in_array($report->report_type,[0,1])) {
			$alidayu = new AlidayuSendController();
			switch($report->report_type){
				case 0:
					//star测试报告通知
					$conections=Students::leftjoin('members','students.parent_id','=','members.id')
					->where(['students.id'=>$report['student_id']])
					->first(['members.email','members.cellphone'])
					->toArray();
					//Messages::sendMobile($conections['cellphone'],[],'SMS_113060007');
					$alidayu->send('upload_star_report',$conections['cellphone']);
					Messages::sendEmail('报告生成提醒',$conections['email'],'messages::starreport',[]);
					break;
				case 1:
					$conections=Students::leftjoin('members','students.parent_id','=','members.id')
					->where(['students.id'=>$report['student_id']])
					->first(['members.email','members.cellphone'])
					->toArray();
					//Messages::sendMobile($conections['cellphone'],[],'SMS_94140020');
					$alidayu->send('upload_stage_report',$conections['cellphone']);
					Messages::sendEmail('报告生成提醒',$conections['email'],'messages::stageReprotInform',[]);
					break;
			}
		}
	}
	/**
	 * 根据家长获取学生
	 * @param Request $request
	 */
	public function getStudents(Request $request){
		$students=Students::crossjoin('student_group as sg','sg.id','=','students.group_id')
				->where(function($where)use($request){
					if ($request->input('star_account')) {
						$where->whereIn('students.id',function($query)use($request){
							$query->select('asign_to')->from('star_account')->where('star_account','like','%'.$request->input('star_account').'%');
						});
					}
				})
				->where(['sg.user_id'=>auth()->id()])
				->get(['students.id','students.name','students.nick_name']);
		return $students;
	}
	/**
	 * 下载报告
	 * */
	public function downloadReport(Request $request) {
		$input=array(
				'student_id'=>$request->input('student_id'),
				'report_id'=>$request->input('report_id'),
				'type'=>$request->input('type'),
		);
		$rules=array(
				'student_id'=>'required|exists:students,id',
				'report_id'=>'required|exists:star_report,id,student_id,'.$input['student_id'],
				'type'=>'required|in:en,zh,stage'
		);
		$messages=array();
		$attributes=array();
		$check=Validator::make($input,$rules,$messages,$attributes);
		if($check->passes()){
			// 中文star报告 转在线观看
			if ($request->input('type')=='zh') {
				$report=StarReport::where(['id'=>$request->input('report_id')])->first();
				if ($report) {
					$data = $report->toArray();
					return $this->view('teacher.srd',$data);
				}else{
					echo '报告不存在！';
				}
			}else{
				$report=StarReport::where(['id'=>$request->input('report_id')])->first()->toArray();
				$exists = Storage::exists($report['pdf_'.$input['type']]);
				if($exists){
					//return redirect($report['pdf_'.$input['type']]);
					ob_clean();
					flush();
					return response()->download($report['pdf_'.$input['type']]);
				}else{
					echo "文件不存在！";
				}
			}
		}else{
			if($check->errors()->has('student_id')){
				echo "孩子不存在！";
			}elseif($check->errors()->has('report_id')){
				echo "报告不存在！";
			}elseif($check->errors()->has('type')){
				echo $input['type']."该类型的阅读报告不存在";
			}
		}
	}
	public function storeDocx($id){
		$report=StarReport::where(['id'=>$id])->first();
		// 获取word模板
		$template = new TemplateProcessor(storage_path('templates/report_template'.$report->star_version.'.docx'));		
		
		// phpword 内容标准化
		$patterns=["/\"/","/>/","/</","/&/"];
		$replaces=['&quot;','&gt;','&lt;','&amp;'];
		foreach ($report->toArray() as $k=>$v) {
			$template->setValue($k, $v?preg_replace($patterns, $replaces,$v):''); // 模板内参数替换
		}

		$starAccount = StarAccount::where(['asign_to'=>$report->student_id])->first();
		$template->setValue('star_account', $starAccount?$starAccount->star_account:''); // 模板内参数替换
		
		$dir='files/starReport/star_report_'.time().'.docx';
		$template->saveAs($dir);
		return $dir;
	}
	public function uploadTxt (Request $request) {
	   $check=validator($request->all(),[
	   		'file'=>'required|file|ext:txt'
	   ]);
	   if ($check->passes()) {
	   	   $content = file_get_contents($request->file('file'));
		   $matchRules=array(
		   		'star_account'=>[
		   				'pattern'=>'/ID: (?:\s*)([^\s.]*)\s/',
		   				'type'=>'string'
		   		],
		   		'printed'=>[
		   				'pattern'=>'/Printed(.*(AM|PM))/',
		   				'type'=>'string'
		   		],
		   		'test_date'=>[
		   				'pattern'=>'/Test Date:(.*(AM|PM))/',
		   				'type'=>'string'
		   		],
		   		'time_used'=>[
		   				'pattern'=>'/Test Time:(.*)[\r]/',
		   				'type'=>'string'
		   		],
		   		'class'=>[
		   				'pattern'=>'/Class:(.*)[\r]/',
		   				'type'=>'string'
		   		],
		   		'grade'=>[
		   				'pattern'=>'/Grade:(.*)Teacher:/',
		   				'type'=>'string'
		   		],
		   		'teacher'=>[
		   				'pattern'=>'/Teacher:(.*)[\r]/',
		   				'type'=>'string'
		   		],
		   		'ss'=>[
		   				'pattern'=>'/SS:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'pr'=>[
		   				'pattern'=>'/PR:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'ge'=>[
		   				'pattern'=>'/GE:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'lm'=>[
		   				'pattern'=>'/Lexile\. Range:(?:\s*)([^\s.]*L)\s/',
		   				'type'=>'string'
		   		],
		   		'irl'=>[
		   				'pattern'=>'/IRL:(?:\s*)([^\s]*)\s/',
		   				'type'=>'string'
		   		],
		   		'estor'=>[
		   				'pattern'=>'/Est(?:.*)ORF:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'wks'=>[ // Word Knowledge and Skills
		   				'pattern'=>'/Word Knowledge and Skills:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'cscm'=>[ // Comprehension Strategies and Constructing Meaning
		   				'pattern'=>'/Comprehension Strategies and Constructing Meaning:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'alt'=>[ // Analyzing Literary Text
		   				'pattern'=>'/Analyzing Literary Text:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'uac'=>[ // Understanding Author's Craft
		   				'pattern'=>'/Understanding Author\'s Craft:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'aaet'=>[ // Analyzing Argument and Evaluating Text:
		   				'pattern'=>'/Analyzing Argument and Evaluating Text:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'zpd'=>[
		   				'pattern'=>'/ZPD:(?:\s*)((\d*|\d*\.\d*)-(\d*|\d*\.\d*))\s/',
		   				'type'=>'string'
		   		],
		   		'vo'=>[
		   				'pattern'=>'/Vocabulary:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'ui'=>[
		   				'pattern'=>'/Understanding and Interpreting Texts:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'er'=>[
		   				'pattern'=>'/Engaging and Responding to Texts:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		],
		   		'wr'=>[
		   				'pattern'=>'/Word Recognition:(?:\s*)(\d*|\d*\.\d*)\s/',
		   				'type'=>'string'
		   		]
		   );
		   $result = [];
		   foreach($matchRules as $k=>$v){
		   		$matches = null;
		   		preg_match($v['pattern'],$content, $matches);
		   		switch ($v['type']){
		   			case 'string': $result[$k]=isset($matches[1])?trim($matches[1]):'';break;
		   			case 'int': $result[$k]=isset($matches[1])?(int)$matches[1]:'';break;
		   		}
		   }
		   $result['test_date'] = date('Y.m.d',strtotime($result['test_date']));
		   $result['time_used'] = preg_replace(['/hours/','/minutes/','/seconds/'],['时','分','秒'], $result['time_used']);
		   return response(['data'=>$result]);
	   }else{
	   	  return response(['message'=>$check->errors()->first()],400);
	   }
	  
	}
}
