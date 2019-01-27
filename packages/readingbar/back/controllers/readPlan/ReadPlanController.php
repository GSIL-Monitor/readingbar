<?php

namespace Readingbar\Back\Controllers\ReadPlan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Readingbar\Back\Models\StudentGroup;
use Readingbar\Back\Models\ReadPlan;
use Readingbar\Back\Models\ReadPlanDetail;
use Validator;
use Storage;
use Readingbar\Back\Models\Books;
use Readingbar\Back\Models\BookStorage;
use Readingbar\Back\Models\ReadPlanProposal;
use Readingbar\Back\Models\ReadPlanGoals;
use Readingbar\Back\Models\Students;
use Messages;
use Readingbar\Back\Models\Members;
use Readingbar\Back\Models\TimedTask;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Orders;
use Readingbar\Back\Models\ServiceFreeze;
use DB;
use Readingbar\Back\Controllers\Spoint\PointController;
use Readingbar\Back\Models\BookStorageLog;
use Readingbar\Back\Models\KuaidiniaoExpress;
use Readingbar\Back\Controllers\Messages\AlidayuSendController;
class ReadPlanController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'readplan.head_title','url'=>'admin/readplan','active'=>true),
	);
	/*▼▼▼▼▼▼▼▼▼▼界面▼▼▼▼▼▼▼▼▼*/
	/*阅读计划-默认页*/
	public function index(Request $request){
		return $this->readPlanList($request);
	}
	/*阅读计划-列表*/
	public function readPlanList(Request $request){
		$data['head_title']=trans('readplan.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['student']=Students::where(['id'=>(int)$request->input('student_id')])->first();
		return $this->view('readPlan.readPlanList', $data);
	}
	/*借阅服务-列表*/
	public function borrowServiceList(Request $request){
		$data['head_title']=trans('borrowService.head_title');
		$data['breadcrumbs']=$data['breadcrumbs']=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'borrowService.head_title','url'=>'admin/borrowService','active'=>true),
		);
		$data['student']=Students::where(['id'=>(int)$request->input('student_id')])->first();
		$data['student_options']=Students::crossjoin('student_group','student_group.id','=','students.group_id')
														->crossjoin('members','members.id','=','students.parent_id')
														->leftjoin('star_account','star_account.asign_to','=','students.id')
														->where(['user_id'=>auth()->id()])
														->get(['students.id','students.nick_name','members.cellphone','members.email','star_account.star_account'])
														->toJson();
		return $this->view('readPlan.borrowServiceList', $data);
	}
	/*阅读计划-表单*/
	public function readPlanForm($id){
		$data['head_title']=trans('readplan.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['plan_id']=$id;
		return $this->view('readPlan.readPlanForm',$data);
	}
	/*借阅服务-表单*/
	public function borrowServiceForm($id){
		$data['head_title']=trans('borrowService.head_title');
		$data['breadcrumbs']=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'borrowService.head_title','url'=>'admin/borrowService','active'=>true),
		);
		$data['plan_id']=$id;
		return $this->view('readPlan.borrowServiceForm',$data);
	}
	/*▲▲▲▲▲▲▲▲▲▲界面▲▲▲▲▲▲▲▲▲*/
	/*▼▼▼▼▼▼▼▼▼▼api▼▼▼▼▼▼▼▼▼*/
	/** 
	 * 创建借阅服务计划
	 * */
	public function createPlan(Request $reqeuest) {
		$check = Validator::make($reqeuest->all(),[
			'for'=>'required|exists:students,id',
			'plan_name'=>'required|string',
			'from'=>'required|date',
			'to'=>'required|date',
			'type'=>'required|in:0,1'
		]);
		if ($check->passes()) {
			ReadPlan::create([
					'for'=>$reqeuest->input('for'),
					'plan_name'=>$reqeuest->input('plan_name'),
					'from'=>$reqeuest->input('from'),
					'to'=>$reqeuest->input('to'),
					'type'=>$reqeuest->input('type'),
					'created_by'=>auth()->id(),
					'status'=>-1
			]);
			return array('status'=>true,'success'=>'计划创建成功！');
		}else{
			return array('status'=>false,'errors'=>$check->errors()->toArray());
		}
	}
	/*获取所有阅读计划*/
	public function getReadPlans(Request $request){
		//判断用户是否是老师
		if(Auth::user()->role==3){
			/*老师-关联学生分组-关联学生-关联阅读计划*/
			$readPlans=StudentGroup::leftjoin('students','students.group_id','=','student_group.id')
				->leftjoin('read_plan','students.id','=','read_plan.for')
				->leftjoin('star_account','students.id','=','star_account.asign_to')
				->where(['student_group.user_id'=>Auth::user()->id])
				->whereNotNull('read_plan.id');
		}else{
			$readPlans=StudentGroup::leftjoin('students','students.group_id','=','student_group.id')
								->leftjoin('star_account','students.id','=','star_account.asign_to')
								->leftjoin('read_plan','students.id','=','read_plan.for');
		}
		
		
		if($request->input('page') && $request->input('page')>1){
			$page=(int)$request->input('page');
		}else{
			$page=1;
		}
		if($request->input('limit') && $request->input('limit')>0){
			$limit=(int)$request->input('limit');
		}else{
			$limit=1000;
		}
		if($request->input('order') && in_array($request->input('order'),['read_plan.for','read_plan.created_at','read_plan.status'])){
			$order=$request->input('order');
		}else{
			$order='for';
		}
		if($request->input('sort') && in_array($request->input('sort'),['desc','asc'])){
			$sort=$request->input('sort');
		}else{
			$sort='asc';
		}
		$readPlans=$readPlans->where(function($where) use ($request){
			if($request->input('status')!=='' && in_array($request->input('status'),[-1,0,1,2,3,4,5,6,7])){
				$where->where(['read_plan.status'=>$request->input('status')]);
			}
			if ($request->input('plan_name')) {
				$where->where('read_plan.plan_name','like','%'.$request->input('plan_name').'%');
			}
			if ($request->input('student_name')) {
				$where->where('students.name','like','%'.$request->input('student_name').'%');
			}
			if ($request->input('star_account')) {
				$where->where('star_account.star_account','like','%'.$request->input('star_account').'%');
			}
			switch($request->input('type')){
				case 0: $where->whereIn('read_plan.type',[0]);break;
				case 1: $where->whereIn('read_plan.type',[1,2]);break;
			}
		});
		$readPlans=$readPlans->where(function($where) use ($request){
			if ($request->input('courier_number')) {
				$where->orwhere('read_plan.r_courier_number','=',$request->input('courier_number'));
				$where->orwhere('read_plan.s_courier_number','=',$request->input('courier_number'));
			}
		});
		switch($request->input('type')){
			case 0: $readPlans=$readPlans->whereIn('read_plan.type',[0]);break;
			case 1: $readPlans=$readPlans->whereIn('read_plan.type',[1,2]);break;
		}
		$total=$readPlans->count();
		$readPlans=$readPlans
				->orderBy($order,$sort)
				->skip($limit*($page-1))
				->take($limit)
				->get(['read_plan.*','students.name as student_name','students.id as student_id','students.nick_name as student_nickname','star_account.star_account'])
				->each(function($item){
					$item->express_1 = KuaidiniaoExpress::where(['plan_id'=>$item->id,'type'=>1])->first();
					$item->express_2 = KuaidiniaoExpress::where(['plan_id'=>$item->id,'type'=>2])->first();
				})
				->toArray();
		$current_page=$page;
		$total_pages=ceil((float)$total/$limit);
		$this->json=array('status'=>true,'suucess'=>'数据获取成功！','current_page'=>$current_page,'total_pages'=>$total_pages,'data'=>$readPlans);
		return $this->echoJson();
	}
	/*获取阅读计划详情*/
	public function getReadPlanById(Request $request){
		$inputs=$request->all();
		$rules=array(
				'plan_id'=>"required|exists:read_plan,id"
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			$readPlan=ReadPlan::where(['id'=>$inputs['plan_id']])->first()->toArray();
			$readPlan['Mr_exists']=$readPlan['Mr_pdf']?true:false;
			$readPlan['Mr_pdf']=$readPlan['Mr_pdf']?url($readPlan['Mr_pdf']):'';
			//计划书籍信息
			$readPlan['books']=ReadPlanDetail::leftjoin('books','read_plan_detail.book_id','=','books.id')
								->where(['plan_id'=>$inputs['plan_id']])
								->get(['read_plan_detail.*','books.book_name','books.summary','books.BL','books.type as book_type'])
								->toArray();
			foreach ($readPlan['books'] as $k=>$v){
				$readPlan['books'][$k]['Ar_pdf_rar_en']=$v['Ar_pdf_rar_en']?url($v['Ar_pdf_rar_en']):null;
				$readPlan['books'][$k]['Ar_pdf_rar_zh']=$v['Ar_pdf_rar_zh']?url($v['Ar_pdf_rar_zh']):null;
				$readPlan['books'][$k]['Ar_pdf_vt_en']=$v['Ar_pdf_vt_en']?url($v['Ar_pdf_vt_en']):null;
				$readPlan['books'][$k]['Ar_pdf_vt_zh']=$v['Ar_pdf_vt_zh']?url($v['Ar_pdf_vt_zh']):null;
				$readPlan['books'][$k]['Ar_pdf_rwaar_en']=$v['Ar_pdf_rwaar_en']?url($v['Ar_pdf_rwaar_en']):null;
				$readPlan['books'][$k]['Ar_pdf_rwaar_zh']=$v['Ar_pdf_rwaar_zh']?url($v['Ar_pdf_rwaar_zh']):null;
			}
			//计划建议信息
			$readPlan['proposal']=ReadPlanProposal::where(['plan_id'=>$inputs['plan_id']])->get()->toArray();
			//计划目标信息
			$readPlan['goals']=ReadPlanGoals::where(['plan_id'=>$inputs['plan_id']])->get()->toArray();
			//关联学生信息
			$column=array(
					'students.*',//students所有字段
					'members.nickname as parent_name',
					'members.email as parent_email',
					'members.cellphone as parent_cellphone',
					'star_account.star_account',
					'star_account.star_password',
			);
			$student=Students::leftjoin('members','students.parent_id','=','members.id')
					   	->leftjoin('star_account','star_account.asign_to','=','students.id')
					   	->where(['students.id'=>$readPlan['for']])
						->first($column)
						->toArray();
			$student['avatar']=$student['avatar']?url($student['avatar']):url('files/avatar/default_avatar.jpg');
			$student['favorite']=unserialize($student['favorite']);
			$student['age']=(int)date("Y",time())-(int)date('Y',strtotime($student['dob']));
			$student['sex']=$student['sex']?'男':'女';
			$student['services']=Students::getStudentServices($student['id']);
			$student['freezeService']=ServiceFreeze::where(['student_id'=>$student['id']])->where('from','<',DB::raw('NOW()'))->where('to','>',DB::raw('NOW()'))->count();
			$student['hasReadBooks']=ReadPlanDetail::crossjoin('read_plan as rp','rp.id','=','read_plan_detail.plan_id')
							->where(['rp.for'=>$readPlan['for']])
							->distinct()
							->get(['book_id'])
							->pluck('book_id');
			if(count($student['services']->toArray())){
				$product=Orders::leftjoin('products as p','p.id','=','orders.product_id')
					->where(['orders.owner_id'=>$student['id'],'orders.status'=>1])
					->orderBy('orders.id','desc')
					->first(['p.product_name']);
				$student['product']=$product?$product->product_name:null;
			}
			
			
			$readPlan['student']=$student;
			
			
			return array('status'=>true,'success'=>'数据获取成功！','data'=>$readPlan);
		}else{
			return array('status'=>false,'error'=>'计划不存在！');
		}
	}
	/*让用户确认阅读计划*/
	public function allowUserConfirm(Request $request){
		$inputs=$request->all();
		$rules=array(
				'plan_id'=>"required|exists:read_plan,id"
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			ReadPlan::where(['id'=>$inputs['plan_id'],'status'=>-1])->update(['status'=>0,'created_by'=>auth()->id()]);
			$readplan=ReadPlan::where(['id'=>$inputs['plan_id']])->first();
			//获取用户信息
			$member=Members::leftjoin('students','students.parent_id','=','members.id')
				->leftjoin('read_plan','read_plan.for','=','students.id')
				->where(['read_plan.id'=>$inputs['plan_id']])
				->first();
			$alidayu = new AlidayuSendController();
			if ($readplan['type']===1) { // 图书借阅
				$alidayu->send('upload_borrow_plan',$member->cellphone);
				//Messages::sendMobile($member->cellphone,[],'SMS_112935008');
			}else if ($readplan['type']===0) { // 定制阅读
				$alidayu->send('upload_read_plan',$member->cellphone);
				//Messages::sendMobile($member->cellphone,[],'SMS_127160106');
			}
			$this->json=array('status'=>true,'success'=>'计划等待用户确认！');
		}else{
			$this->json=array('status'=>false,'error'=>'计划不存在！');
		}
		return $this->echoJson();
	}
	/*撤销让用户确认的计划*/
	public function revokeReadPlan(Request $request){
		$inputs=$request->all();
		$rules=array(
				'plan_id'=>"required|exists:read_plan,id"
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			ReadPlan::where(['id'=>$inputs['plan_id'],'status'=>0])->update(['status'=>-1]);
			//取消定时任务
			TimedTask::where(['unique'=>md5('confirm_read_plan_'.$inputs['plan_id'])])->update(['status'=>1]);
			$this->json=array('status'=>true,'success'=>'计划已撤回！');
		}else{
			$this->json=array('status'=>false,'error'=>'计划不存在！');
		}
		return $this->echoJson();
	}
	/*修改阅读计划的起始于结束日期*/
	public function changeFromTo(Request $request){
		
		$inputs=$request->all();
		$rules=array(
				'plan_id'=>"required|exists:read_plan,id,status,-1",
				'from'=>"required",
				'to'=>"required"
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			ReadPlan::where(['id'=>$inputs['plan_id'],'status'=>-1])->update(['from'=>$inputs['from'],'to'=>$inputs['to']]);
			$this->json=array('status'=>true,'success'=>'日期已修改！');
		}else{
			if($check->errors()->has('plan_id')){
				$this->json=array('status'=>false,'error'=>'当前不可改！');
			}else{
				$this->json=array('status'=>false,'error'=>'请设置正确起始日期和结束日期！');
			}
		}
		return $this->echoJson();
	}
	/*上传Ar报告*/
	public function uploadArReport(Request $request){
		$inputs=$request->all();
		$rules=array(
				'id'=>"required|exists:read_plan_detail,id"
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			$update=array();
			//阅读测评报告
			if($request->file('Ar_pdf_rar_en')){
				$update['Ar_pdf_rar_en']=$this->saveArPdf($request->file('Ar_pdf_rar_en'), md5("Ar_pdf_rar_en_".$request->input('id')));
				if(!$update['Ar_pdf_rar_en']){
					$this->json=array('status'=>false,'error'=>'Ar报告英文版上传格式错误！');
				}
			}
			if($request->file('Ar_pdf_rar_zh')){
				$update['Ar_pdf_rar_zh']=$this->saveArPdf($request->file('Ar_pdf_rar_zh'), md5("Ar_pdf_rar_zh_".$request->input('id')));
				if(!$update['Ar_pdf_rar_zh']){
					$this->json=array('status'=>false,'error'=>'Ar报告中文版上传格式错误！');
				}
			}
			//词汇测试
			if($request->file('Ar_pdf_vt_en')){
				$update['Ar_pdf_vt_en']=$this->saveArPdf($request->file('Ar_pdf_vt_en'), md5("Ar_pdf_vt_en_".$request->input('id')));
				if(!$update['Ar_pdf_vt_en']){
					$this->json=array('status'=>false,'error'=>'Ar报告英文版上传格式错误！');
				}
			}
			if($request->file('Ar_pdf_vt_zh')){
				$update['Ar_pdf_vt_zh']=$this->saveArPdf($request->file('Ar_pdf_vt_zh'), md5("Ar_pdf_vt_zh_".$request->input('id')));
				if(!$update['Ar_pdf_vt_zh']){
					$this->json=array('status'=>false,'error'=>'Ar报告中文版上传格式错误！');
				}
			}
			//读写能力分析报告
			if($request->file('Ar_pdf_rwaar_en')){
				$update['Ar_pdf_rwaar_en']=$this->saveArPdf($request->file('Ar_pdf_rwaar_en'), md5("Ar_pdf_rwaar_en_".$request->input('id')));
				if(!$update['Ar_pdf_rwaar_en']){
					$this->json=array('status'=>false,'error'=>'Ar报告英文版上传格式错误！');
				}
			}
			if($request->file('Ar_pdf_rwaar_zh')){
				$update['Ar_pdf_rwaar_zh']=$this->saveArPdf($request->file('Ar_pdf_rwaar_zh'), md5("Ar_pdf_rwaar_zh_".$request->input('id')));
				if(!$update['Ar_pdf_rwaar_zh']){
					$this->json=array('status'=>false,'error'=>'Ar报告中文版上传格式错误！');
				}
			}
			if(!$this->json){
				ReadPlanDetail::where(['id'=>$request->input('id')])->update($update);
				$this->json=array('status'=>true,'success'=>'Ar编辑完成！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'计划详情不存在！');
		}
		$callback="<script type=\"text/javascript\">";
		$callback.="window.parent.readPlanDetail.doArCallback(".$this->echoJson().");";
		$callback.="</script>";
		return $callback;
	}
	/*保存Ar报告pdf文件*/
	public function saveArPdf($file,$filename){
		if($file && in_array($file->extension(),['pdf'])){
			$dir='files/ArReportPdf/'.$filename.'.'.$file->extension();
			Storage::put(
					$dir,
					file_get_contents($file->getRealPath())
					);
			return $dir;
		}else{
			return false;
		}
	}
	/*上传本月报告*/
	public function uploadMRReport(Request $request){
		$inputs=$request->all();
		$rules=array(
				'id'=>"required|exists:read_plan,id"
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			$update=array();
			//阅读测评报告
			if($request->file('Mr_pdf')){
				$update['Mr_pdf']=$this->saveMrPdf($request->file('Mr_pdf'), md5("Mr_pdf_".$request->input('id')));
				if(!$update['Mr_pdf']){
					$this->json=array('status'=>false,'error'=>'本月报告上传格式错误！');
				}
			}
			if(!$this->json){
				ReadPlan::where(['id'=>$request->input('id')])->update($update);
				$this->json=array('status'=>true,'success'=>'本月报告上传完成！','pdf'=>url($update['Mr_pdf']));
				// 通知家长本月阅读报告已经上传
				$rp=ReadPlan::where(['id'=>$request->input('id')])->first();
				$m=Members::leftjoin('students as s','s.parent_id','=','members.id')
					->where(['s.id'=>$rp->for])
					->first();
				if ($m && $m->cellphone) {
					Messages::sendMobile($m->cellphone,[],'SMS_94075012');
				}
			}
		}else{
			$this->json=array('status'=>false,'error'=>'计划不存在！');
		}
		$callback="<script type=\"text/javascript\">";
		$callback.="window.parent.readPlanDetail.doMrCallback(".$this->echoJson().");";
		$callback.="</script>";
		return $callback;
	}
	/*保存本月报告pdf文件*/
	public function saveMrPdf($file,$filename){
		if($file && in_array($file->extension(),['pdf'])){
			$dir='files/MrReportPdf/'.$filename.'.'.$file->extension();
			Storage::put(
					$dir,
					file_get_contents($file->getRealPath())
					);
			return $dir;
		}else{
			return false;
		}
	}
	/*阅读计划书籍管理*/
	/*书籍搜索*/
	public function seachBooks(Request $request){
		$books=Books::where(function($where)use($request){
					if($request->input('book_name')){
						$where->where(['books.book_name'=>$request->input('book_name')]);
					}
					if($request->input('author')){
						$where->where(['books.author'=>$request->input('author')]);
					}
					if($request->input('publisher')){
						$where->where(['books.publisher'=>$request->input('publisher')]);
					}
					if($request->input('series')){
						$where->where('books.series','like','%'.$request->input('series').'%');
					}
					if($request->input('ISBN')){
						$where->where(['books.ISBN'=>$request->input('ISBN')]);
					}
					if($request->input('BL')){
						$bls=explode('-',$request->input('BL'));
						if(count($bls)==2){
							$where->whereBetween('books.BL',$bls);
						}else{
							$where->where(['books.BL'=>(int)$request->input('BL')]);
						}
					}
					if($request->input('type')){
						$where->where(['books.type'=>$request->input('type')]);
					}
					if($request->input('IL')){
						$where->where(['books.IL'=>$request->input('IL')]);
					}
					if($request->input('ARQuizType')){
						$ARQuizTypes=explode(';',$request->input('ARQuizType'));
						foreach ($ARQuizTypes as $v){
							$where->where('books.ARQuizType','like','%'.$v.'%');
						}
					}
					if($request->input('ARQuizNo')){
						$where->where(['books.ARQuizNo'=>$request->input('ARQuizNo')]);
					}
					if($request->input('topic')){
						$where->where('books.topic','like','%'.$request->input('topic').'%');
					}
				})
				->orderBy('books.id','desc')
				->paginate($request->input('limit')?(int)$request->input('limit'):10);
		foreach ($books as $b){
			$b['image']=config('readingbar.isbnImage').$b['ISBN'].".jpg";
			$b['status1']=BookStorage::where(['status'=>1,'book_id'=>$b['id']])->count();
			$b['status23']=BookStorage::where(['book_id'=>$b['id']])->whereIn('status',[2,3])->count();
			$b['status4']=BookStorage::where(['status'=>4,'book_id'=>$b['id']])->count();
		}
		return $books;
	}
	/*加入书籍*/
	public function addBookIntoPlan(Request $request){
		$inputs=$request->all();
		$rules=array(
			'plan_id'=>"required|exists:read_plan,id",
			'book_id'=>"required|exists:books,id",
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			//阅读计划的状态
			$RP=ReadPlan::where(['read_plan.id'=>$inputs['plan_id']])
				->first(['read_plan.*']);
			if($RP){
				if($RP->status==-1){
					//判断该阅读计划中是否存在该书籍了
					$added=ReadPlanDetail::where(['plan_id'=>$inputs['plan_id'],'book_id'=>$inputs['book_id']])->first();
					if(!$added){
						//获取在库书籍
						$bs=BookStorage::where(['book_id'=>$inputs['book_id'],'status'=>1])->first();
						$b=Books::where(['id'=>$inputs['book_id']])->first();
						if($bs){
							$create=array(
									'plan_id'=>$inputs['plan_id'],
									'book_id'=>$inputs['book_id'],
									'serial' =>$bs->serial,
									'Ar_id'	 =>$b->ARQuizNo
							);
							ReadPlanDetail::create($create);
							BookStorageLog::create(
									array(
											'book_id'=>$inputs['book_id'],
											'serial'=>$bs->serial,
											'status'=>4,
											'operate_by'=>Auth()->id(),
											'plan_id'=>$inputs['plan_id'],
											'memo'=>'老师选定书籍'
									)
							);
							//库存书籍改变状态为锁定
							//BookStorage::where($bs->toArray())->update(['status'=>4]);
							$this->json=array('status'=>true,'success'=>'书籍已加入！');
						}else{
							$this->json=array('status'=>false,'error'=>'该书籍暂无库存！');
						}
					}else{
						$this->json=array('status'=>false,'error'=>'该书籍已加入计划，不可再次添加！');
					}
				}else{
					$this->json=array('status'=>false,'error'=>'该阅读计划为不可编辑状态！');
				}
			}else{
				$this->json=array('status'=>false,'error'=>'阅读计划不存在！');
			}
		}else{
			if($check->errors()->has('plan_id')){
				$this->json=array('status'=>false,'error'=>'计划不存在！');
			}else{
				$this->json=array('status'=>false,'error'=>'书籍不存在！');
			}
		}
		return $this->echoJson();
	}
	/*移除书籍*/
	public function removeBookFromPlan(Request $request){
		$inputs=$request->all();
		$rules=array(
			'id'=>"required|exists:read_plan_detail,id"
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			//阅读计划的状态
			$RP=ReadPlan::leftjoin('read_plan_detail','read_plan_detail.plan_id','=','read_plan.id')
				->where(['read_plan_detail.id'=>$inputs['id']])
				->first(['read_plan.*']);
			if($RP){
				if($RP->status==-1){
					$RPD=ReadPlanDetail::where(['id'=>$inputs['id']])->first(['book_id','serial']);
					ReadPlanDetail::where(['id'=>$inputs['id']])->delete();
					//BookStorage::where($RPD->toArray())->update(['status'=>1]);
					BookStorageLog::create(
							array(
									'book_id'=>$RPD->book_id,
									'serial'=>$RPD->serial,
									'status'=>1,
									'operate_by'=>Auth()->id(),
									'plan_id'=>$RP->id,
									'memo'=>'老师移除选定书籍'
							)
					);
					$this->json=array('status'=>true,'success'=>'书籍已删除！');
				}else{
					$this->json=array('status'=>false,'error'=>'该阅读计划为不可编辑状态！');
				}
			}else{
				$this->json=array('status'=>false,'error'=>'阅读计划不存在！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'记录不存在！');
		}
		return $this->echoJson();
	}
	/*阅读建议-添加*/
	public function addRPProposal(Request $request){
		$inputs=$request->all();
		$rules=array(
				'plan_id'=>'required|exists:read_plan,id',
				'proposal'=>'required'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			$create=array(
					'plan_id'=>$inputs['plan_id'],
					'proposal'=>$inputs['proposal']
			);
			ReadPlanProposal::create($create);
			$this->json=array('status'=>true,'success'=>'阅读建议已添加！');
		}else{
			if($check->errors()->has('plan_id')){
				$this->json=array('status'=>false,'error'=>'计划不存在！');
			}else{
				$this->json=array('status'=>false,'error'=>'建议内容不能为空！');
			}
		}
		return $this->echoJson();
	}
	/*阅读建议-修改*/
	public function editRPProposal(Request $request){
		$inputs=$request->all();
		$rules=array(
				'id'=>'required|exists:read_plan_proposal,id',
				'proposal'=>'required'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			ReadPlanProposal::where(['id'=>$inputs['id']])->update(['proposal'=>$inputs['proposal']]);
			$this->json=array('status'=>true,'success'=>'阅读建议已修改！');
		}else{
			if($check->errors()->has('id')){
				$this->json=array('status'=>false,'error'=>'建议不存在！');
			}else{
				$this->json=array('status'=>false,'error'=>'建议内容不能为空！');
			}
		}
		return $this->echoJson();
	}
	/*阅读建议-删除*/
	public function deleteRPProposal(Request $request){
		$inputs=$request->all();
		$rules=array(
				'proposal_id'=>'required|exists:read_plan_proposal,id'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			ReadPlanProposal::where(['id'=>$inputs['proposal_id']])->delete();
			$this->json=array('status'=>true,'success'=>'阅读建议已删除！');
		}else{
			$this->json=array('status'=>false,'error'=>'建议不存在！');
		}
		return $this->echoJson();
	}
	/*阅读目标-添加*/
	public function addRPGoals(Request $request){
		$inputs=$request->all();
		$rules=array(
				'plan_id'=>'required|exists:read_plan,id',
				'goals'=>'required'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			$create=array(
					'plan_id'=>$inputs['plan_id'],
					'goals'=>$inputs['goals']
			);
			ReadPlanGoals::create($create);
			$this->json=array('status'=>true,'success'=>'阅读目标已添加！');
		}else{
			if($check->errors()->has('plan_id')){
				$this->json=array('status'=>false,'error'=>'计划不存在！');
			}else{
				$this->json=array('status'=>false,'error'=>'目标内容不能为空！');
			}
		}
		return $this->echoJson();
	}
	/*阅读目标-修改*/
	public function editRPGoals(Request $request){
		$inputs=$request->all();
		$rules=array(
				'id'=>'required|exists:read_plan_goals,id',
				'goals'=>'required'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			ReadPlanGoals::where(['id'=>$inputs['id']])->update(['goals'=>$inputs['goals']]);
			$this->json=array('status'=>true,'success'=>'阅读目标已修改！');
		}else{
			if($check->errors()->has('id')){
				$this->json=array('status'=>false,'error'=>'计划不存在！');
			}else{
				$this->json=array('status'=>false,'error'=>'目标内容不能为空！');
			}
		}
		return $this->echoJson();
	}
	/*阅读目标-删除*/
	public function deleteRPGoals(Request $request){
		$inputs=$request->all();
		$rules=array(
				'goals_id'=>'required|exists:read_plan_goals,id'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			ReadPlanGoals::where(['id'=>$inputs['goals_id']])->delete();
			$this->json=array('status'=>true,'success'=>'阅读目标已删除！');
		}else{
			$this->json=array('status'=>false,'error'=>'计划不存在！');
		}
		return $this->echoJson();
	}
	/*阅读目标-完成*/
	public function completeRPGoals(Request $request){
		$inputs=$request->all();
		$rules=array(
				'goals_id'=>'required|exists:read_plan_goals,id,status,0'
		);
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			$student_id=Students::crossJoin('read_plan as rp','rp.for','=','students.id')
								->crossJoin('read_plan_goals as rpg','rp.id','=','rpg.plan_id')
								->where(['rpg.id'=>$request->input('goals_id')])
								->first(['students.id'])
								->id;
			PointController::increaceByRule([
					'rule'=>'read_plan_goal',
					'student_id'=>$student_id
			]);
			ReadPlanGoals::where(['id'=>$inputs['goals_id']])->update(['status'=>1]);
			$this->json=array('status'=>true,'success'=>'阅读目标已完成！');
		}else{
			$this->json=array('status'=>false,'error'=>'目标已完成！');
		}
		return $this->echoJson();
	}
	/*▲▲▲▲▲▲▲▲▲▲api▲▲▲▲▲▲▲▲▲*/
}
