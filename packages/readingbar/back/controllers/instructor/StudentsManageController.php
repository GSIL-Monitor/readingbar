<?php

namespace Readingbar\Back\Controllers\Instructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Auth;
use Validator;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Users;
use Readingbar\Back\Models\StudentGroup;
use DB;
use Readingbar\Back\Models\Services;
use Readingbar\Back\Models\ServiceFreeze;
use Readingbar\Back\Models\Orders;
use Readingbar\Back\Models\Members;
use Readingbar\Back\Models\StarAccount;
use Readingbar\Back\Models\ServiceStatus;
class StudentsManageController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'instructor_sm.head_title','url'=>'admin/instructor/studentManage','active'=>true),
	);
	private $teacher_role_id=3;
  	/**
	 * 学生列表
	 */
	public function studentManageList(){
		$data['head_title']=trans('instructor_sm.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['services']=Services::get()->toJson();
		$data['teachers']=Users::where(['role'=>3])->get(['id','name']);
		return $this->view('instructor.studentManageList', $data);
	}
	/**
	 * 学生列表
	 */
	public function getStudentManageList(Request $request){
		$students = $this->filterStudents($request);
		$students = $this->supplementInfo($students);
		return $students;
	}
	/**
	 * 条件筛选学生
	 */
	public function filterStudents($request) {
		$students = Students::where(function ($where) use($request){
			// 关联学生
			if ($request->input('student_name')) {
				$where->where('students.name','like','%'.$request->input('student_name').'%');
			}
			if ($request->input('student_nickname')) {
				$where->where('students.nick_name','like','%'.$request->input('student_nickname').'%');
			}
			if($request->input('province')){
				$where->where('students.province','like','%'.$request->input('province').'%');
			}
			if($request->input('grade')){
				$where->where('students.grade','like','%'.$request->input('grade').'%');
			}
			// 关联家长
			if ($request->input('cellphone') || $request->input('email')) {
				$where->whereIn('students.parent_id',function($query) use($request) {
					return $query->select(['id'])
								->from('members')
								->where(function($where)use($request){
									if ($request->input('cellphone')) {
										$where->where(['members.cellphone'=>$request->input('cellphone')]);
									}
									if ($request->input('email')) {
										$where->where(['members.email'=>$request->input('email')]);
									}
								});
				});
			}
			
			// 关联star账号
			if ($request->input('star_account')) {
				$where->whereIn('students.id',function($query) use($request) {
					return $query->select(['asign_to'])
								->from('star_account')
								->where(['star_account'=>'readingbar'.$request->input('star_account')]);
				});
			}
			
			// 关联服务
			if ($request->input('service_id')) {
				$where->whereIn('students.id',function($query) use($request) {
					return $query->select(['student_id'])
					->from('service_status')
					->where(['service_id'=>$request->input('service_id')])
					->where('expirated','>',DB::raw('NOW()'));
				});
			}
			
			// 关联老师
			if ($request->input('teacher_id')) {
				$where->whereIn('students.group_id',function($query) use($request) {
					return $query->select(['id'])
						->from('student_group')
						->where(['user_id'=>$request->input('teacher_id')]);
				});
			}
			
			// 关联订单
			if (($request->input('from')!=null && strtotime($request->input('from'))) && ($request->input('to')!=null && strtotime($request->input('to')))) {
				$where->whereIn('students.id',function($query) use($request) {
					return $query->select('o.owner_id')
								->from('orders as o')
								->leftjoin('orders as r',function($join){
									$join->on('o.id','=','r.refund_oid');
									$join->on('r.order_type','=', DB::raw(2));
								})
								->where(function($where)use($request){
									if ($request->input('from')!=null && strtotime($request->input('from'))) {
										$where->where('o.completed_at','>',$request->input('from'));
									}
									if ($request->input('to')!=null && strtotime($request->input('to'))) {
										$where->where('o.completed_at','<',date("Y-m-d",strtotime($request->input('to'))+60*60*24));
									}
								})
								->groupBy('o.id')
								->havingRaw('count(r.id) = 0');
				});
			}
		})
		->crossjoin('orders as o',function($join) use($request){
			$join->on('students.id','=','o.owner_id');
		})
		->groupBy('students.id')
		->distinct()
		->select('students.*')
		->orderBy(DB::raw('max(o.completed_at)'),'desc')
		->paginate($request->input('limit')>0?$request->input('limit'):10);
		return $students;
	}
	/**
	 * 补充列表学生数据
	 */
	public function supplementInfo($students){
		foreach ($students as $k=>$s){
			$parent = Members::where(['id'=>$s->parent_id])->first();
			if($parent) {
				$students[$k]['parent_cellphone']=$parent->cellphone;
				$students[$k]['parent_name']=$parent->nickname;
				$students[$k]['parent_email']=$parent->email;
			}
			$staraccount = StarAccount::where(['asign_to'=>$s->id])->first();
			if ($staraccount) {
				$students[$k]['star_account']=$staraccount->star_account;
				$students[$k]['star_password']=$staraccount->star_password;
			}
			$teacher = Users::leftjoin('student_group','student_group.user_id','=','users.id')
									->where(['student_group.id'=>$s->group_id])->first(['users.*']);
			if ($teacher) {
				$students[$k]['teacher']=$teacher->name;
			}
			$students[$k]['avatar']=$s['avatar']?url($s['avatar']):url('files/avatar/default_avatar.jpg');
			$students[$k]['favorite']=unserialize($s['favorite']);
			$students[$k]['expiration_time']=date('Y-m-d',strtotime($students[$k]['expiration_time']));
			$students[$k]['age']=(int)date("Y",time())-(int)date('Y',strtotime($s['dob']));
			$students[$k]['BoughtLog']=Orders::leftjoin('products as p','p.id','=','orders.product_id')
		   		->where(['orders.owner_id'=>$s['id'],'orders.status'=>1])
		   		->orderBy('orders.id','desc')
		   		->get(['p.product_name','completed_at'])
		   		->toArray();
			$students[$k]['boughtLogUrl']=url('admin/boughtLog?type=nick_name&keyword='.$s['nick_name']);
			
	   		$students[$k]['services']=DB::table('services as s')
		   		->crossJoin('service_status as ss','s.id','=','ss.service_id')
		   		->where('ss.student_id','=',$s['id'])
		   		->where('ss.expirated','>','2016-01-01')
		   		->get(['s.service_name','expirated',DB::raw('if (ss.expirated>NOW(),true,false) as status')]);
		   	$students[$k]['freezeService'] = ServiceFreeze::where(['student_id'=>$s['id']])
		   														->where('from','<',DB::raw('Now()'))
		   														->where('to','>',DB::raw('Now()'))
		   														->count();
		}
		return $students;
	}
	/**
	 * 老师分配
	 */
	public function getTeachersList(Request $request){
		return Users::where(['role'=>$this->teacher_role_id])->get(['id','name']);
	}
	/**
	 * 老师分配
	 */
	public function asignTeacher(Request $request){
		$check=Validator::make($request->all(),[
				'teacher_id'=>"required|exists:users,id,role,".$this->teacher_role_id,
				'student_id'=>"required|exists:students,id"
		]);
		if(!$check->fails()){
			$sg=array(
					'user_id'=>$request->input('teacher_id'),
					'group_name'=>'default'
			);
			if(StudentGroup::where($sg)->count()){
				$r=StudentGroup::where($sg)->first()->toArray();
			}else{
				$r=StudentGroup::create($sg)->toArray();
			}
			Students::where('id','=',$request->input('student_id'))->update(['group_id'=>$r['id']]);
			return array('status'=>true,'success'=>'分配成功！');
		}else{
			$error='未知错误！';
			if($check->errors()->has('teacher_id')){
				$error="老师不存在！";
			}
			if($check->errors()->has('student_id')){
				$error="学生不存在！";
			}
			return array('status'=>false,'error'=>$error);
		}
	}
	public function freezeService(Request $request){
		$check=Validator::make($request->all(),[
				'student_id'=>"required|exists:students,id",
				'fromDate'=>"required|date",
				'toDate'=>"required|date"
		]);
		if(!$check->fails()){
			$days=abs(strtotime($request->input('fromDate'))-strtotime($request->input('toDate')))/(24*60*60);
			$old_days=ServiceFreeze::where('from','like',date('Y',time()).'%')->where(['student_id'=>$request->input('student_id')])->sum('days');
			//当年冻结天数校验
			if($old_days+$days>30){
				$lastDays=30-$old_days;
				return array('status'=>false,'error'=>'今年该学生还可冻结天数为'.$lastDays.'天,请重新设置时间段！');
			}
			//避免冻结日期重复
			$rp=ServiceFreeze::where(function($where) use($request){
				$where->where(['student_id'=>$request->input('student_id')])
							->where('from','<=',$request->input('fromDate'))
							->where('to','>',$request->input('toDate'));
			})->orWhere(function($where) use($request){
				$where->where(['student_id'=>$request->input('student_id')])
							->where('from','<',$request->input('toDate'))
							->where('to','>=',$request->input('toDate'));
			})->orWhere(function($where) use($request){
				$where->where(['student_id'=>$request->input('student_id')])
							->where('from','>=',$request->input('fromDate'))
							->where('to','<=',$request->input('toDate'));
			});
			if($rp->count()){
				return array('status'=>false,'error'=>'时间段与已冻结的时间段有交集,请重新设置时间段！');
			}
			$freeze=array(
					'student_id'=>$request->input('student_id'),
					'from'=>$request->input('fromDate'),
					'to'=>$request->input('toDate'),
					'days'	=>$days
			);
			ServiceFreeze::create($freeze);
			
			$hasServices=Students::getStudentServices($request->input('student_id'));
			foreach($hasServices as $s){
				$p=Products::where(['service_id'=>$s['service_id']])->first();
				$order=array(
						'owner_id'	   =>$request->input('student_id'),
						'order_id'     =>date('YmdHis',time()),
						'days'     	   =>$days,
						'product_id' =>$p->id,
						'total'          =>0,
						'price'          =>0,
						'deposit'        =>0,
						'extra_price'        =>0,
						'status'		     =>1,
						'member_del' =>1,
						'memo'		      =>'冻结延期订单',
						'completed_at'=>DB::raw('NOW()')
				);
				Orders::create($order);
			}
			DB::select('call updateStudentServices('.$request->input('student_id').')');
			return array('status'=>true,'success'=>'服务已冻结！');
		}else{
			return array('status'=>false,'error'=>$check->errors()->first());
		}
	}
}
