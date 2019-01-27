<?php

namespace Readingbar\Teacher\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Models\Students;
use Readingbar\Teacher\Backend\Models\StudentGroup;
use Readingbar\Teacher\Backend\Models\BookComment;
use Readingbar\Teacher\Backend\Models\ReadPlan;
use Readingbar\Teacher\Backend\Models\BookStorage;
use Auth;
use Validator;
use GuzzleHttp\json_encode;
use Symfony\Component\Debug\header;
use Monolog\Handler\error_log;
use Readingbar\Back\Models\Products;
use DB;
use Readingbar\Back\Models\ServiceStatus;
use Readingbar\Back\Models\Orders;
use Readingbar\Back\Models\STSessions;
use Readingbar\Back\Models\StarReport;
use Readingbar\Back\Models\ServiceFreeze;
use Excel;
class TstudentsController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'tstudents.head_title','url'=>'admin/tstudents','active'=>true),
	);
	private $json=array();
   public function index(){
	   	$data['head_title']=trans('tstudents.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		return view("Readingbar/teacher/backend::tstudents_list",$data);
   }
   public function show($type,Request $request){
   		switch($type){
   			case 'tstudents':$this->tstudents($request);break;
   			case 'stgroups':$this->stgroups($request);break;
   			case 'SComments':$this->SComments($request);break;
   			case 'sessions':return $this->viewSessions($request);break;
   			case 'getSessions':return $this->getSessions($request);break;
   			default:$this->json=array('status'=>false,'msg'=>'接口不存在！');
   		}
//    		header("Content-type: text/html; charset=utf-8");
//    		echo $this->json['msg']?$this->json['msg']:'';exit;
   		echo json_encode($this->json);
   }
   public function store($type,Request $request){
	   	switch($type){
	   		case 'newgroup':$this->newgroup($request);break;
   			case 'removegroup':$this->removegroup($request);break;
   			case 'schanggroup':$this->schanggroup($request);break;
   			case 'renamegroup':$this->editgroup($request);break;
   			case 'examineSComment':$this->examineSComment($request);break;
   			case 'createSessions':return $this->createSessions($request);break;
   			case 'updateSessions':return $this->updateSessions($request);break;
   			case 'deleteSessions':return $this->deleteSessions($request);break;
	   		default:$this->json=array('status'=>false,'msg'=>'接口不存在！');
	   	}
	   	echo json_encode($this->json);
   }
   //获取学生信息
   public function tstudents($request){
	   	$Ts=new Students();
	   	$Tid=Auth::user()->id;
	   	$Ts=$Ts->leftjoin('student_group','student_group.id','=','students.group_id');
	   	$Ts=$Ts->leftjoin('members','students.parent_id','=','members.id');
	   	$Ts=$Ts->leftjoin('star_account','star_account.asign_to','=','students.id');
	   	$Ts=$Ts->where(['student_group.user_id'=>$Tid]);
	   	//条件
	   	if($request->input('parent')!=null){
	   		$Ts=$Ts->where('members.nickname','like','%'.$request->input('parent').'%');
	   	}
	   	if($request->input('student_nickname')!=null){
	   		$Ts=$Ts->where('students.nick_name','like','%'.$request->input('student_nickname').'%');
	   	}
	   	if($request->input('student_name')!=null){
	   		$Ts=$Ts->where('students.name','like','%'.$request->input('student_name').'%');
	   	}
	   	if($request->input('student_nickname')!=null){
	   		$Ts=$Ts->where('students.nick_name','like','%'.$request->input('student_nickname').'%');
	   	}
	   	if($request->input('email')!=null){
	   		$Ts=$Ts->where('members.email','like','%'.$request->input('email').'%');
	   	}
	   	if($request->input('cellphone')!=null){
	   		$Ts=$Ts->where('members.cellphone','like','%'.$request->input('cellphone').'%');
	   	}
	   	if($request->input('star_account')!=null){
	   		$Ts=$Ts->where('star_account.star_account','like','%'.$request->input('star_account').'%');
	   	}
	   	if($request->input('province')!=null){
	   		$Ts=$Ts->where('students.province','like','%'.$request->input('province').'%');
	   	}
	   	if(in_array($request->input('grade'),[1,2,3,4,5,6,7,8,9,10,11,12,'k'])){
	   		$Ts=$Ts->where(['students.grade'=>$request->input('grade')]);
	   	}
	   	if($request->input('group')!=null){
	   		$Ts=$Ts->where(['students.group_id'=>$request->input('group')]);
	   	}
	   	switch ($request->input('payStatus')){
	   		case '1';$Ts=$Ts->whereNotIn('students.id',ServiceStatus::where('expirated','>',DB::raw('NOW()'))->get(['student_id'])->pluck('student_id')->all());break;
	   		case '2';$Ts=$Ts->whereIn('students.id',ServiceStatus::where('expirated','>',DB::raw('NOW()'))->get(['student_id'])->pluck('student_id')->all());break;
	   	}
	   	if($request->input('limit')>0){
	   		$limit=(int)$request->input('limit');
	   	}else{
	   		$limit=1;
	   	}
	   	//条件
	   	//需要的值
	   	$column=array(
	   		'students.*',//students所有字段
	   		'student_group.group_name',
	   		'student_group.user_id as teacher_id',
	   		'members.nickname as parent_name',
	   		'members.email as parent_email',
	   		'members.cellphone as parent_cellphone',
	   		'star_account.star_account',
	   		'star_account.star_password',
	   	);
	   	//需要的值
	   	$Ts=$Ts->distinct()->select($column)->paginate($limit);
	   	//数据处理
	   	foreach($Ts as $k=>$s){
	   		$Ts[$k]['avatar']=$s['avatar']?url($s['avatar']):url('files/avatar/default_avatar.jpg');
	   		$Ts[$k]['favorite']=unserialize($s['favorite']);
	   		$Ts[$k]['expiration_time']=date('Y-m-d',strtotime($Ts[$k]['expiration_time']));
	   		$Ts[$k]['age']=(int)date("Y",time())-(int)date('Y',strtotime($s['dob']));
	   		$Ts[$k]['freezeService']=ServiceFreeze::where(['student_id'=>$s['id']])->where('from','<',DB::raw('NOW()'))->where('to','>',DB::raw('NOW()'))->count();
	   		$Ts[$k]['sessionsHref']=url('admin/tstudents/sessions?student_id='.$s['id']);
	   		$Ts[$k]['BoughtLog']=Orders::leftjoin('products as p','p.id','=','orders.product_id')
	   					->where(['orders.owner_id'=>$s['id'],'orders.status'=>1])
	   					->orderBy('orders.id','desc')
	   					->get(['p.product_name','completed_at'])
	   					->toArray();
	   		$Ts[$k]['services']=DB::table('services as s')
	   										->crossJoin('service_status as ss','s.id','=','ss.service_id')
	   										->where('ss.student_id','=',$s['id'])
	   										->where('ss.expirated','>','2016-01-01')
	   										->get(['s.service_name','expirated',DB::raw('if (ss.expirated>NOW(),true,false) as status')]);
	   	}
	   	//数据处理
	   	$this->json=array('status'=>true,'data'=>$Ts);
   }
   //获取分组信息
   public function stgroups($request){
   		$Tid=Auth::user()->id;
   		$Tgs=new StudentGroup();
   		$Tgs=$Tgs->where('student_group.user_id','=',$Tid);
   		$Total=$Tgs->count();
   		$Tgs=$Tgs->get()->toArray();
   		$this->json=array('status'=>true,'total'=>$Total,'data'=>$Tgs);
   }
   //新建分组
   public function newgroup($request){
   		$Tid=Auth::user()->id;
   		$cg=Validator::make($request->all(),
   			[
   				'group_name'=>'exists:student_group,group_name,user_id,'.$Tid
   			]
   		);
   		if($cg->fails()){
   			$g=array(
   				'group_name'=>$request->input('group_name'),
   				'user_id'=>$Tid
   			);
   			StudentGroup::create($g);
   			$this->json=array('status'=>true,'msg'=>'分组创建成功！');
   		}else{
   			$this->json=array('status'=>false,'msg'=>'分组名称不能为空或分组已存在！');
   		}
   }
   //删除分组
   public function removegroup($request){
	   	$Tid=Auth::user()->id;
	   	$cg=Validator::make($request->all(),
	   			[
	   				'group_id'=>'exists:student_group,id,user_id,'.$Tid
	   			]
	   	);
	   	//判断分组是否存在并属于当前用户
	   	if(!$cg->fails()){
	   		$g=array(
	   				'id'=>$request->input('group_id'),
	   				'user_id'=>$Tid
	   		);
	   		$r=StudentGroup::where($g)->first()->toArray();
	   		//判断要删除的分钟是否是默认分组
	   		if($r['group_name']!='default'){
	   			//转移分组学生至默认分组下
	   			$gsts=Students::where(['group_id'=>$request->input('group_id')])->get(['id'])->toArray();
	   			if(count($gsts)){
	   				$dg=StudentGroup::where(['group_name'=>'default','user_id'=>$Tid])->first();
	   				//判断默认分组
	   				if(!$dg){
	   					$dg=StudentGroup::create(['group_name'=>'default','user_id'=>$Tid])->toArray();
	   				}else{
	   					$dg=$dg->toArray();
	   				}
	   				foreach ($gsts as $s){
	   					Students::where($s)->update(['group_id'=>$dg['id']]);
	   				}
	   			}
	   			$r=StudentGroup::where($g)->where('group_name','<>','default')->delete();
	   			$this->json=array('status'=>true);
	   		}else{
	   			$this->json=array('status'=>false,'msg'=>'默认分组不能删除！');
	   		}
	   	}else{
	   		$this->json=array('status'=>false,'msg'=>'分组不存在！');
	   	}
   }
   //学生转移分组
   public function schanggroup($request){
	   	$Tid=Auth::user()->id;
	   	$c=Validator::make($request->all(),
	   			[
	   				'student_id'=>'exists:students,id',
	   				'group_id'=>'exists:student_group,id,user_id,'.$Tid
	   			]
	   	);
	   	//判断学生和要转移的分组是否存在
	   	if(!$c->fails()){
	   		//判断该学生是否属于当前用户的学生分组
	   		$s=Students::leftjoin('student_group','students.group_id','=','student_group.id')->where(['students.id'=>$request->input('student_id'),'user_id'=>$Tid])->first(['students.*']);
	   		if($s){
	   			$s=$s->toArray();
	   			Students::where($s)->update(['group_id'=>$request->input('group_id')]);
	   			$this->json=array('status'=>true,'msg'=>'学生已转移！');
	   		}else{
	   			$this->json=array('status'=>false,'msg'=>'您无权修改该学生的分组！');
	   		}
	   	}else{
	   		$error="未知错误！";
	   		if($c->errors()->has('student_id')){
	   			$error="学生不存在！";
	   		}
	   		if($c->errors()->has('group_id')){
	   			$error="要转移的分组不存在！";
	   		}
	   		$this->json=array('status'=>false,'msg'=>$error);
	   	}
   }
   //编辑分组信息
   public function editgroup($request){
   		$Tid=Auth::user()->id;
   		$cg=Validator::make([
   				'new_name'=>$request->input('group_name'),
   				'group_name'=>$request->input('group_name'),
   				'group_id'=>$request->input('group_id'),
   				'default_group'=>$request->input('group_id')
   			],
   			[
   				'new_name'=>'required',
   				'group_name'=>'exists:student_group,group_name,user_id,'.$Tid,
   				'group_id'=>'exists:student_group,id,user_id,'.$Tid,
   				'default_group'=>'exists:student_group,id,group_name,default',
   			]
	   	);
   		//判断分组是否存在及新的分组名称是否存在
   		$cg1=$cg->errors()->has('new_name');//判断新分组名是否为空
   		$cg2=$cg->errors()->has('group_name');//判断新分组名在所属用户的分组内是否唯一 
   		$cg3=!$cg->errors()->has('group_id');//判断要编辑的当前用户的学生分组是否存在 
   		$cg4=!$cg->errors()->has('default_group');//判断要编辑的当前用户的学生分组是否是默认分组
   		if(!$cg1 && $cg2 && $cg3 && !$cg4){
   			StudentGroup::where(['id'=>$request->input('group_id')])->update(['group_name'=>$request->input('group_name')]);
   			$this->json=array('status'=>true,'msg'=>'分组信息已更新！');
   		}else{
   			$error="未知错误！";
   			if($cg1){
   				$error="分组名不能为空！";
   			}
   			if($cg4){
   				$error="分组为默认分组，不可修改信息！";
   			}
   			if(!$cg2){
   				$error="分组名称已存在！";
   			}
   			if(!$cg3){
   				$error="分组不存在！";
   			}
   			$this->json=array('status'=>false,'msg'=>$error);
   		}
   }
   //判断学生与当前老师是否对应关系
   private function checkTSR($tid,$sid){
	   	$Groups=StudentGroup::where('user_id','=',$tid)->get(['id']);
	   	$Gids=array();
	   	foreach ($Groups as $g){
	   		$Gids[]=$g['id'];
	   	}
   		$r=Students::where(['id'=>$sid])->wherein('group_id',$Gids)->count();
   		return $r>0?true:false;
   }
   //获取学生评论
   public function SComments($request){
   		$Tid=Auth::user()->id;
   		//判断学生是否存在
   		$ct=Validator::make([
   				'student_id'=>$request->input('student_id')
   			],
   			[
   				'student_id'=>'exists:students,id'
   			]
	   	);
   		if(!$ct->fails()){
   			//判断学生与当前老师是否对应关系
   			if($this->checkTSR($Tid, $request->input('student_id'))){
   				$comments=BookComment::leftjoin('books','books.ISBN','=','book_comment.ISBN')
   						->leftjoin('students','students.id','=','book_comment.commented_by')
		   				->where(['commented_by'=>$request->input('student_id')])
		   				->orderby('updated_at','desc')
		   				->get(['book_comment.*','books.book_name','students.nick_name','students.name','students.avatar'])
		   				->toArray();
   				foreach ($comments as $k=>$c){
   					$comments[$k]['avatar']=$c['avatar']?url($c['avatar']):url('files/avatar/default_avatar.jpg');;
   				}
   				
   				$this->json=array('status'=>true,'msg'=>'数据获取成功！','data'=>$comments);
   			}else{
   				$this->json=array('status'=>false,'msg'=>'您无权操作该学生！');
   			}
   		}else{
   			$this->json=array('status'=>false,'msg'=>'学生不存在！');
   		}
   }
   //审核学生评论
   public function examineSComment($request){
	   	$Tid=Auth::user()->id;
	   	//判断学生是否存在
	   	$sc=Validator::make([
   				'scid'=>$request->input('scid')
   			],
   			[
   				'scid'=>'exists:book_comment,id'
   			]
	   	);
	   	if(!$sc->fails()){
	   		$comment=BookComment::where(['id'=>$request->input('scid')])->first();
	   		//判断学生与当前老师是否对应关系
	   		if($this->checkTSR($Tid, $comment['commented_by'])){
	   			if(in_array($request->input('status'),['open','close','confirm'])){
	   				BookComment::where(['id'=>$request->input('scid')])->update(['status'=>$request->input('status')]);
	   				$this->json=array('status'=>true,'msg'=>'数据获取成功！');
	   			}else{
	   				$this->json=array('status'=>false,'msg'=>'该状态不存在！');
	   			}
	   		}else{
	   			$this->json=array('status'=>false,'msg'=>'您无权操作该学生的评论！');
	   		}
	   	}else{
	   		$this->json=array('status'=>false,'msg'=>'评论不存在！');
	   	}
   }
   //沟通记录2级界面
   public function viewSessions(Request $request){
	   	$data['head_title']=trans('tstudents.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
	  
   		$check=validator::make($request->all(),[
   			'student_id'=>'required|exists:students,id'
   		]);
   		if($check->passes()){
   			$Tid=Auth::user()->id;
   			if($this->checkTSR($Tid,$request->input('student_id'))){
   				$data['types']=collect(trans('tstudents.session_types'))->toJson();
   				$data['sessions']=$this->getSessions($request)->toJson();
   				$data['student']=Students::leftjoin('star_account as sa','students.id','=','sa.asign_to')
   						->leftjoin('members as m','students.parent_id','=','m.id')
   						->where(['students.id'=>$request->input('student_id')])
   						->select([
   								'students.*',//students所有字段
   								'm.nickname as parent_name',
   								'm.email as parent_email',
   								'm.cellphone as parent_cellphone',
   								'sa.star_account',
   								'sa.star_password',
   						])->first();
   						$data['student']['avatar']=$data['student']['avatar']?url($data['student']['avatar']):url('files/avatar/default_avatar.jpg');
   						$data['student']['favorite']=unserialize($data['student']['favorite']);
   						$data['student']['expiration_time']=date('Y-m-d',strtotime($data['student']['expiration_time']));
   						$data['student']['age']=(int)date("Y",time())-(int)date('Y',strtotime($data['student']['dob']));
   						$data['student']['services']=Students::getStudentServices($data['student']['id']);
   						$data['student']['sessionsHref']=url('admin/tstudents/sessions?student_id='.$data['student']['id']);
   						$data['student']['freezeService']=ServiceFreeze::where(['student_id'=>$data['student']['id']])->where('from','<',DB::raw('NOW()'))->where('to','>',DB::raw('NOW()'))->count();
   							
   						$data['student']['BoughtLog']=Orders::leftjoin('products as p','p.id','=','orders.product_id')
   						->where(['orders.owner_id'=>$request->input('student_id'),'orders.status'=>1])
   						->orderBy('orders.id','desc')
   						->get(['p.product_name','completed_at'])
   						->toArray();
   						$data['student']['services']=DB::table('services as s')
   						->crossJoin('service_status as ss','s.id','=','ss.service_id')
   						->where('ss.student_id','=',$request->input('student_id'))
   						->where('ss.expirated','>','2016-01-01')
   						->get(['s.service_name','expirated',DB::raw('if (ss.expirated>NOW(),true,false) as status')]);
   				$data['reports']=StarReport::where(['student_id'=>$request->input('student_id')])->get();
   				return view("Readingbar/teacher/backend::sessions",$data);
   			}else{
   				return redirect()->back();
   			}
   		}else{
   			return redirect()->back();
   		}
   }
   public function getSessions(Request $request){
   	 	$sessions=STSessions::where(['student_id'=>$request->input('student_id')])->get();
   	 	$types=trans('tstudents.session_types');
   	 	foreach ($sessions as $v){
   	 		$v['type_name']=isset($types[$v['type']])?$types[$v['type']]:'未知方式';
   	 	}
   	 	return $sessions;
   }
   public function createSessions(Request $request){
   		$check=Validator::make($request->all(),[
   				'time'=>'required|date',
   				'content'=>'required',
   				'type'=>'required|in:'.collect(trans('tstudents.session_types'))->keys()->implode(','),
   				'student_id'=>'required|exists:students,id',
   		]);
   		if($check->passes()){
   			$create=array(
   					'time'=>$request->input('time'),
   					'content'=>$request->input('content'),
   					'type'=>$request->input('type'),
   					'student_id'=>$request->input('student_id'),
   			);
   			STSessions::create($create);
   			return ['status'=>true,'success'=>'数据已保存！'];
   		}else{
   			return ['status'=>false,'error'=>$check->errors()->first()];
   		}
   }
   public function updateSessions(Request $request){
  	 	$check=Validator::make($request->all(),[
   				'id'  =>'required|exists:st_sessions,id',
   				'time'=>'required|date',
   				'content'=>'required',
   				'type'=>'required|in:'.collect(trans('tstudents.session_types'))->keys()->implode(',')
   		]);
   		if($check->passes()){
   			$create=array(
   					'time'=>$request->input('time'),
   					'content'=>$request->input('content'),
   					'type'=>$request->input('type'),
   			);
   			STSessions::where(['id'=>$request->input('id')])->update($create);
   			return ['status'=>true,'success'=>'数据已保存！'];
   		}else{
   			return ['status'=>false,'error'=>$check->errors()->first()];
   		}
   }
   public function deleteSessions(Request $request){
   		$check=Validator::make($request->all(),[
   				'id'  =>'required|exists:st_sessions,id'
   		]);
   		if($check->passes()){
   			STSessions::where(['id'=>$request->input('id')])->delete();
   			return ['status'=>true,'success'=>'数据已删除！'];
   		}else{
   			return ['status'=>true,'success'=>'数据不存在,删除失败！'];
   		}
   }
   //导出学生相关数据
   public function exportStudents(Request $request){
        $tid=Auth()->id();
	   	$star_report=$this->starReport($request,$tid);
	   	$stage_report=$this->stageReport($request,$tid);
	   	$students_info=$this->studentsInfo($request,$tid);
	   	ob_end_clean();
	   	Excel::create('学生信息'.date('Y-m-d',time()),function($excel) use ($star_report,$stage_report,$students_info){
	   		$excel->sheet('学生信息', function($sheet) use ($students_info){
	   			$sheet->rows($students_info);
	   		});
   			$excel->sheet('star评测报告', function($sheet) use ($star_report){
   				$sheet->rows($star_report);
   			});
   			$excel->sheet('阶段性报告', function($sheet) use ($stage_report){
   				$sheet->rows($stage_report);
   			});
	   	})->store('xls')->export('xls');
   }
   //学生信息
   private function  studentsInfo($request,$tid){
   		$students=Students::leftjoin('student_group as sg','sg.id','=','students.group_id')
   							->leftjoin('star_account as sa','sa.asign_to','=','students.id')
   							->leftjoin('members as m','m.id','=','students.parent_id')
						   	->where(['sg.user_id'=>$tid])
						   	->select([
						   			'students.id',
						   			'students.name',
						   			'students.nick_name',
						   			'm.nickname',
						   			'm.email',
						   			'm.cellphone',
						   			'students.grade',
						   			'students.school_name',
						   			'students.school_name',
						   			'students.favorite',
						   			DB::raw('CONCAT(students.province,students.city,students.area,students.address)'),
						   			'sa.star_account',
						   			'students.created_at',
						   	])
						   	->get()
						   	->each(function($item){
						   		$item['favorite']=implode(',',unserialize($item['favorite']));
						   		return $item;
						   	})->toArray();
		$title=array('学生序号','学生名称','学生昵称','家长','家长邮箱','家长手机','年级','学校','偏好','地址','star账号','学生添加时间');
				
		return collect($students)->prepend($title);
   }
   //star评测报告
   private function starReport($request,$tid){
	   	$reports=StarReport::leftjoin('students as s','s.id','=','star_report.student_id')
	   	->leftjoin('star_account as sa','sa.asign_to','=','s.id')
	   	->leftjoin('student_group as sg','sg.id','=','s.group_id')
	   	->where(['sg.user_id'=>$tid,'star_report.report_type'=>0])
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
   private function stageReport($request,$tid){
	   	$reports=StarReport::leftjoin('students as s','s.id','=','star_report.student_id')
	   	->leftjoin('star_account as sa','sa.asign_to','=','s.id')
	   	->leftjoin('student_group as sg','sg.id','=','s.group_id')
	   	->where(['sg.user_id'=>$tid,'star_report.report_type'=>1])
	   	->orderBy('star_report.id','desc')
	   	->select([
	   			'star_report.id',
	   			's.name as student_name',
	   			's.nick_name as student_nickname',
	   			'sa.star_account',
	   			's.grade',
	   			's.school_name',
	   			'star_report.memo',
	   			'star_report.created_at',
	   	])
	   	->get()
	   	->toArray();
	   	$title=array('报告序号','学生姓名','学生昵称','star账号','年级','学校','报告备注','报告创建时间');
   		return collect($reports)->prepend($title);
   }
}
