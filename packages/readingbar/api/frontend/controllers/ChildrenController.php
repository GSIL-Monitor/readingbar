<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Readingbar\Back\Models\Students;
use Validator;
use Readingbar\Api\Functions\AvatarFunction;
use Illuminate\Support\Facades\Input;
use Superadmin\Backend\Models\User;
use Readingbar\Api\Frontend\Models\StarAccountAsign;
use Readingbar\Api\Frontend\Models\StarAccount;
use Readingbar\Api\Frontend\Models\StudentGroup;
use Readingbar\Api\Frontend\Models\Members;
use Auth;
use Messages;
use DB;
use Readingbar\Back\Models\Discount;
use Readingbar\Api\Frontend\Models\Orders;
use Readingbar\Back\Controllers\Spoint\PointController;
class ChildrenController extends FrontController
{
	private $member=null;
	public function __construct(){
		$this->member=auth('member')->member();
	}
	/*获取所有孩子信息*/
	public function all(Request $request){
		$students=new Students();
		$students=$students
		->leftjoin('star_account_asign','star_account_asign.asign_to','=','students.id')
		->leftjoin('star_account','star_account_asign.account_id','=','star_account.id')
		->leftjoin('s_point_status','s_point_status.student_id','=','students.id')
		->where(['parent_id'=>$this->member->id,'del'=>0]);
		
		$limit=(int)$request->input('limit');
		if($limit<=0){
			$limit=10;
		}
		/*页数控制*/
		$students=$students->select(['students.*','star_account','star_password','s_point_status.point'])->paginate($limit);
		
		foreach ($students as $k=>$v){
			$students[$k]['avatar']=$v['avatar']?url($v['avatar']):url('files/avatar/default_avatar');
			$students[$k]['sex']=$v['sex']?'男':'女';
			$students[$k]['age']=$this->birthday($v['dob']);
			$students[$k]['services']=Students::getStudentServices($v['id']);
			$students[$k]['point']=(int)$students[$k]['point'];
		}
		return $students;
	}
	/*获取孩子信息*/
	public function childById(Request $request){
		$input=array(
				'id'=>$request->input('id'),
				'parent_id'=>$this->member->id
		);
		$rules=array(
				'id'=>'required|exists:students,id,parent_id,'.$this->member->id,
		);
		$attributes=array(
				'id'=>trans('students.column_id'),
		);
		$check=Validator::make($input,$rules,array(),$attributes);
		if($check->passes()){
			$student=Students::where($input)->first()->toArray();
			$student['favorite']=serialize($student['favorite']);
			$this->json=array('status'=>true,'success'=>'成功获取孩子信息！','data'=>$student);
		}else{
			$this->json=array('status'=>false,'error'=>'孩子信息获取失败！','inputerrors'=>$check->messages()->toArray());
		}
		$this->echoJson();
	}
	/*新增孩子信息*/
	public function newChild(Request $request){
		$avatar=AvatarFunction::setAvatar(Input::file('avatarFile'),'avatar_student_'.time(),$request->input('avatar_width'), $request->input('avatar_height'), $request->input('avatar_x'),$request->input('avatar_y'));
		$input=array(
				'nick_name'=>$request->input('nick_name'),
				'avatar'=>$avatar?$avatar:'files/avatar/avatar_student_sex'.$request->input('sex').'.jpg',
				'grade'=>$request->input('grade'),
				'favorite'=>$request->input('favorite'),
				'address'=>$request->input('address'),
				'dob'=>$request->input('dob'),
				'province'=>$request->input('province'),
				'city'=>$request->input('city'),
				'area'=>$request->input('area'),
				'sex'=>$request->input('sex'),
				'parent_id'=>$this->member->id
		);
		$rules=array(
				'nick_name'=>'required|max:15',
				'avatar'=>'required',
				'dob'=>'required|date',
				'sex'=>'required|in:0,1',
				'grade'=>'required',
				'favorite'=>'required|array'
		);
		$attributes=array(
				'name'=>trans('students.column_name'),
				'nick_name'=>trans('students.column_nick_name'),
				'avatar'=>trans('students.column_avatar'),
				'dob'=>trans('students.column_dob'),
				'sex'=>trans('students.column_sex'),
				'grade'=>trans('students.column_grade'),
				'school_name'=>trans('students.column_school_name'),
				'province'=>trans('students.column_province'),
				'city'=>trans('students.column_city'),
				'area'=>trans('students.column_area'),
				'favorite'=>trans('students.column_favorite'),
				'address'=>trans('students.column_address'),
		);
		$check=Validator::make($input,$rules,array(),$attributes);
		if($check->passes()){
			$input['favorite']=serialize($input['favorite']);
			$input['name']=$input['nick_name'];
			$student=Students::create($input);
			//免费评测标识
			$student['freeStar']=$request->input('freeStar');
			$this->asignChildren($student);
			//孩子创建成功动作
			$this->completeCreateChild($student);
			return redirect('member')->with(['alert'=>'孩子添加成功！']);
			$this->json=array('status'=>true,'success'=>'孩子添加成功！');
		}else{
			//var_dump($check->messages()->toArray());exit;
			return redirect()->back()->withErrors($check->errors())->withInput();
			$this->json=array('status'=>false,'error'=>'孩子添加失败！','inputerrors'=>$check->messages()->toArray());
		}
		$this->echoJson();
	}
	public function completeCreateChild($student){
		
		//创建第一个孩子，会员名下孩子获得积分
		PointController::increaceByRule([
				'rule'=>'create_first_child_tm',
				'student_id'=>$student->id,
				'member_id'=>auth('member')->id()
		]);
		//创建第一个孩子，会员获得优惠券
		Discount::giveByRule(auth('member')->id(), 'create_first_child_tm',['member_id'=>auth('member')->id()],'student_'.$student->id);
		
		//获取关联推广员
		$cp=auth('member')->getConnetedPromoter();
		if($cp){
			//获取关联推广员名下孩子
			$cpchildren=Students::where(['parent_id'=>$cp->member_id,'del'=>0])->get();
			//创建第一个孩子，关联推广员名下孩子获积分
			foreach($cpchildren as $s){
				PointController::increaceByRule([
						'rule'=>'create_first_child_tp',
						'student_id'=>$s->id,
						'member_id'=>auth('member')->id(),
						'promotions_type'=>$cp->type
				]);
			}
			//创建第一个孩子，关联推广员获得优惠券
			Discount::giveByRule($cp->member_id, 'create_first_child_tp',['member_id'=>auth('member')->id(),'promotions_type_id'=>$cp->type],'student_'.$student->id);
		}
	}
	/*修改孩子信息*/
	public function modifyChild(Request $request){
		$avatar=AvatarFunction::setAvatar(Input::file('avatarFile'),'avatar_student_'.$request->input('id'),$request->input('avatar_width'), $request->input('avatar_height'), $request->input('avatar_x'),$request->input('avatar_y'));
		$input=array(
				'id'=>$request->input('id'),
				'name'=>$request->input('name'),
				'nick_name'=>$request->input('nick_name'),
				'avatar'=>$avatar?$avatar:$request->input('avatar'),
				'grade'=>$request->input('grade'),
				'school_name'=>$request->input('school_name'),
				'favorite'=>$request->input('favorite'),
				'address'=>$request->input('address'),
				'dob'=>$request->input('dob'),
				'sex'=>$request->input('sex'),
				'province'=>$request->input('province'),
				'city'=>$request->input('city'),
				'area'=>$request->input('area'),
				'parent_id'=>$this->member->id
		);
		$rules=array(
				'id'=>'required|exists:students,id,parent_id,'.$this->member->id,
				'nick_name'=>'required|max:15|unique:students,nick_name,'.$request->input('id').',id',
				'avatar'=>'required',
				'dob'=>'required|date',
				'sex'=>'required|in:0,1',
				'grade'=>'required',
				'favorite'=>'required|array'
		);
		$attributes=array(
				'id'=>trans('students.column_id'),
				'name'=>trans('students.column_name'),
				'nick_name'=>trans('students.column_nick_name'),
				'avatar'=>trans('students.column_avatar'),
				'dob'=>trans('students.column_dob'),
				'sex'=>trans('students.column_sex'),
				'grade'=>trans('students.column_grade'),
				'school_name'=>trans('students.column_school_name'),
				'province'=>trans('students.column_province'),
				'city'=>trans('students.column_city'),
				'area'=>trans('students.column_area'),
				'favorite'=>trans('students.column_favorite'),
				'address'=>trans('students.column_address')
		);
		$check=Validator::make($input,$rules,array(),$attributes);
		if($check->passes()){
			$where=array(
					'id'=>$input['id'],
					'parent_id'=>$this->member->id
			);
			$update=array(
					'name'=>$input['nick_name'],
					'nick_name'=>$input['nick_name'],
					'avatar'=>$input['avatar'],
					'dob'=>$input['dob'],
					'sex'=>$input['sex'],
					'grade'=>$input['grade'],
					'school_name'=>$input['school_name'],
					'province'=>$input['province'],
					'city'=>$input['city'],
					'area'=>$input['area'],
					'favorite'=>serialize($input['favorite']),
					'address'=>$input['address'],
			);
			Students::where($where)->update($update);
			return redirect('member/children/baseinfo/'.$input['id']);
			$this->json=array('status'=>true,'success'=>'孩子修改成功！');
		}else{
			return redirect()->back()->withErrors($check->errors())->withInput();
			$this->json=array('status'=>false,'error'=>'孩子修改失败！','inputerrors'=>$check->messages()->toArray());
		}
		$this->echoJson();
	}
	/*删除孩子信息*/
	public function deleteChild(Request $request){
		$input=array(
				'id'=>$request->input('id'),
				'parent_id'=>$this->member->id
		);
		$rules=array(
				'id'=>'required|exists:students,id,parent_id,'.$this->member->id,
		);
		$attributes=array(
				'id'=>trans('students.column_id'),
		);
		$check=Validator::make($input,$rules,array(),$attributes);
		if($check->passes()){
			//判断孩子是否为未付费
			if(!Students::hasService($request->input('id'))){
				Students::where(['id'=>$request->input('id'),'parent_id'=>$this->member->id])->update(['del'=>1]);
				$this->json=array('status'=>true,'success'=>'孩子删除成功！');
			}else{
				$this->json=array('status'=>false,'error'=>'该孩子已付费，无法删除！','inputerrors');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'孩子删除失败！','inputerrors'=>$check->messages()->toArray());
		}
		$this->echoJson();
	}
	/*创建孩子时自动分配老师和star账号*/
	public function asignChildren($student){
		//获取老师，按老师学生数顺序排序
		$sql=" select t.*,count(s.`name`) 'students' from users t ";
		$sql.=" left join student_group sg on sg.user_id=t.id  ";
		$sql.=" left join students s on s.group_id=sg.id";
		$sql.=" where t.role=3";
		$sql.=" GROUP BY t.id";
		$sql.=" order by students";
		$teachers=DB::select($sql);
		foreach ($teachers as $t){
			//创建老师的默认分组
			$group=StudentGroup::where(['user_id'=>$t->id,'group_name'=>'default'])->first();
			if(!$group){
				$group=StudentGroup::create(['user_id'=>$t->id,'group_name'=>'default']);
			}
			//自动分配学生给老师
			Students::where(['id'=>$student->id])->update(['group_id'=>$group['id']]);
			break;
		}
	}
	//计算年龄
	private function birthday($birthday){
		$age = strtotime($birthday);
		if($age === false){
			return false;
		}
		list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age));
		$now = strtotime("now");
		list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now));
		$age = $y2 - $y1;
		if((int)($m2.$d2) < (int)($m1.$d1))
			$age -= 1;
		return $age;
	}
	
}
