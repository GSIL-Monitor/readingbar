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
use Readingbar\Back\Models\Orders;
use DB;
class InstructorController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'instructor.head_title','url'=>'admin/instructor','active'=>true),
	);
  	/**
	 * 今日报名会员列表
	 */
	public function todayRegisterMemberList(){
		$data['head_title']=trans('instructor.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('instructor.todayRegisterMemberList', $data);
	}
	/**
	 * 今日报名会员列表
	 */
	public function getTodayRegisterMemberList(Request $request){
		$students=Students::join('orders as o','o.owner_id','=','students.id')
				  ->leftjoin('members as m','m.id','=','students.parent_id')
				  ->leftjoin('student_group as sg','sg.id','=','students.group_id')
				  ->leftjoin('users','sg.user_id','=','users.id')
				  ->leftjoin('star_account as sa','sa.asign_to','=','students.id')
				  ->where(['o.status'=>1]);
		if ($request->input('from') || $request->input('to')) {
			if ($request->input('from')!=null && strtotime($request->input('from'))) {
				$students=$students->where('o.completed_at','>',$request->input('from'));
			}
			if ($request->input('to')!=null && strtotime($request->input('to'))) {
				$students=$students->where('o.completed_at','<',date("Y-m-d",strtotime($request->input('to'))+60*60*24));
			}
		}else {
			$students=$students->where('o.completed_at','like',date('Y-m-d',time()).'%');
		}	 
		 $students=$students ->where('m.nickname','like','%'.$request->input('parent').'%')
				  ->where('students.name','like','%'.$request->input('student_name').'%')
				  ->where('students.nick_name','like','%'.$request->input('student_nickname').'%')
				  ->where('students.province','like','%'.$request->input('province').'%')
				  ->where('students.grade','like','%'.($request->input('grade')?$request->input('grade'):null).'%')
				  ->select(array(
				  		'students.*',//students所有字段
				   		'sg.group_name',
				   		'sg.user_id as teacher_id',
				   		'm.nickname as parent_name',
				   		'm.email as parent_email',
				   		'm.cellphone as parent_cellphone',
				   		'sa.star_account',
				   		'sa.star_password',
				  		'users.name as teacher'
				  ))
				  ->orderBy('o.completed_at','desc')
				  ->distinct()
				  ->paginate(10);
		//数据处理
		foreach ($students as $k=>$s){
			$students[$k]['avatar']=$s['avatar']?url($s['avatar']):url('files/avatar/default_avatar.jpg');
	   		$students[$k]['favorite']=unserialize($s['favorite']);
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
		}
		return $students;
	}
}
