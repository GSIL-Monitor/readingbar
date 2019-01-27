<?php

namespace Readingbar\Readinginstruction\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Readinginstruction\Backend\Models\students;
use Readingbar\Readinginstruction\Backend\Models\User;
use Readingbar\Readinginstruction\Backend\Models\StudentGroup;
use Validator;
use GuzzleHttp\json_encode;
use Readingbar\Member\Frontend\Models\Student;
class StudentdistributionController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'studentdistribution.head_title','url'=>'admin/studentdistribution','active'=>true),
	);
	private $json;
	private $teacher_role_id=3;//老师分组ID
   public function index(){
	   	$data['head_title']=trans('studentdistribution.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		return view("Readingbar/readinginstruction/backend::students_list",$data);
   }
   public function show($type,Request $request){
   		switch ($type){
   			case "students":$this->getStudents($request);break;
   			case "teachers":$this->getTeachers($request);break;
   			case "dodistribute":$this->dodistribute($request);break;
   		}
   		echo json_encode($this->json);
   }
   public function getStudents($request){
   	$students=new students();
   	$columns=array('students.*','student_group.user_id as teacher_id','members.nickname as parent_name');
   	$students=$students->leftJoin('members', 'members.id', '=', 'students.parent_id');
   	$students=$students->leftJoin('student_group', 'student_group.id', '=', 'students.group_id');
   	//条件
   	if($request->input('name')!=null){
   		$students=$students->orwhere('name','like','%'.$request->input('name').'%');
   	}
   	//条件
   	 
   	//页数 及每页显示记录的数量
   	$page=$request->input('page')>1?(int)$request->input('page'):1;
   	$limit=$request->input('limit')>0?(int)$request->input('limit'):10;
   	$start=($page-1)*$limit;
   	$total=$students->count();
   	$totalpages=ceil((float)$total/$limit);
   	$students=$students->skip($start)->take($limit)->orderBy('id', 'desc')->get($columns);
   	//页数 及每页显示记录的数量
   	 
   	//相关数据及状态
   	foreach ($students as $k=>$v){
   		//头像处理
   		$students[$k]['avatar']=$v['avatar']?url($v['avatar']):url('files/avatar/default_avatar.jpg');;
   	}
   	//相关数据及状态
   	$this->json=array('status'=>true,'total'=>$total,'total_pages'=>$totalpages,'current_page'=>$page,'data'=>$students);
   }
   public function getTeachers($request){
   		$teachers=User::where('role','=',$this->teacher_role_id)->get();
   		$this->json=array('status'=>true,'data'=>$teachers);
   }
   public function dodistribute($request){
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
   			Student::where('id','=',$request->input('student_id'))->update(['group_id'=>$r['id']]);
   			$this->json=array('status'=>true,'msg'=>'分配成功！');
   		}else{
   			$error='未知错误！';
   			if($check->errors()->has('teacher_id')){
   				$error="老师不存在！";
   			}
   			if($check->errors()->has('student_id')){
   				$error="学生不存在！";
   			}
   			$this->json=array('status'=>false,'msg'=>$error);
   		}
   		
   }
   
}
