<?php

namespace Readingbar\Member\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Member\Backend\Models\members;
use Validator;
class MembersController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'members.head_title','url'=>'admin/members','active'=>true),
	);
   public function index(){
	   	$data['head_title']=trans('members.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		$data['columns']=array('id','cellphone','email','nickname','actived','created_at','updated_at');
   		$data['memberss'] = members::select($data['columns'])->paginate(15);
   		$data['success'] = session('success')?session('success'):'';
   		$data['error'] = session('error')?session('error'):'';
   		return view("Readingbar/member/backend::members_list",$data);
   }
public function ajax_memberList(Request $request){
		$columns=array('id as selected','id','cellphone','email','nickname','actived','created_at','updated_at');
		$order=array('id','cellphone','email','nickname','actived','created_at','updated_at');
		if($request->input('page') && $request->input('page')>1){
			$page=(int)$request->input('page');
		}else{
			$page=1;
		}
		if($request->input('limit') && $request->input('limit')>1){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		if($request->input('order') && in_array($request->input('order'),$order)){
			$order=$request->input('order');
		}else{
			$order='id';
		}
		if($request->input('sort') && in_array($request->input('sort'),['asc','desc'])){
			$sort=$request->input('sort');
		}else{
			$sort='asc';
		}
		$members=Members::where("id","like","%".$request->input('like')."%")
			->orWhere("nickname","like","%".$request->input('like')."%")
			->orWhere("cellphone","like","%".$request->input('like')."%")
			->orWhere("email","like","%".$request->input('like')."%")
			->orderBy($order,$sort)
			->skip(($page-1)*$limit)->take($limit)
			->get($columns);
		$members_count=Members::where("id","like","%".$request->input('like')."%")
			->orWhere("nickname","like","%".$request->input('like')."%")
			->orWhere("cellphone","like","%".$request->input('like')."%")
			->orWhere("email","like","%".$request->input('like')."%")
			->count();
		foreach ($members as $k=>$v){
			$members[$k]['avatar']=$v['avatar']!=null?url($v['avatar']):url('files/avatar/default_avatar.jpg');
			$members[$k]['editurl']=url('admin/members/'.$v['id'].'/edit');
			$members[$k]['deleteurl']=url('admin/members/'.$v['id'].'/delete');
		}
		$json=array(
			'status'=>true,
			'current_page'=>$page,
			'total_pages'=>ceil((float)$members_count/$limit),
			'total'=>$members_count,
			'data'=>$members
		);
 		echo json_encode($json);
	}
   public function show(){
	   	
   }
   public function edit($id){
   		return $this->getForm($id);
   }
   public function create(){
   		return $this->getForm();
   }
   public function getForm($id=0){
	   	$data['head_title']=trans('members.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		if($id){
   			$data['action']="admin/members/$id";
   			$data['method']="PUT";
   			$data['members']=members::where('id','=',$id)->first();
   		}else{
   			$data['action']="admin/members";
   			$data['method']="POST";
   		}
   		return view("Readingbar/member/backend::members_form",$data);
   }
   public function update(Request $request){
   		$columns=array('cellphone','email','nickname','password','question','answer','remember_token','actived');
   		$id=(int)$request->input('id');
   		$validator = Validator::make($request->all(), [
   			'id'	=>'required|in:memberses,id,'.$id,
   			'nickname'=>'required|min:2|unique:members,nickname,'.$id.',id',
   			'cellphone'=>'required|regex:/^[1][358][0-9]{9}$/|unique:members,cellphone,'.$id.',id',
   			'email'	   =>'required|email|unique:members,email,'.$id.',id'
   		]);
   		if ($validator->fails()) {
   			return redirect("admin/members/$id/edit")
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			//密码校验
   			$password=Validator::make(
   				[
   					'password'=>$request->input('password'),
   					'password_confirmation'=>$request->input('password_confirmation'),
   					'required'=>$request->input('password'),
   				]
   				, [
	   				'required'	=>'required',
		   			'password'	=>'min:6|confirmed'
	   			]);
   			//判断用户是否填写了password
   			if(!$password->errors()->has('required')){ //是
   				//验证密码是否符合规范
   				if($password->errors()->has('password')){//否
   					return redirect("admin/members/$id/edit")
   					->withErrors($password)
   					->withInput();
   				}
   				$members=array();
   				foreach ($columns as $column){
   					switch ($column){
   						case 'password':$members[$column]=bcrypt($request->input($column));break;
   						default:$members[$column]=$request->input($column);
   					}
   				}
   			}else{//否
   				$members=array();
   				foreach ($columns as $column){
   					switch ($column){
   						case 'password':;break;
   						default:$members[$column]=$request->input($column);
   					}
   				}
   			}
   			
   			members::where("id","=",$id)->update($members);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/members');
   		}
   		
   }
   public function store(Request $request){
   		//校验
   		$validator = Validator::make($request->all(), [
			'cellphone'=>'required|regex:/^[1][358][0-9]{9}$/|unique:members,cellphone',
   			'email'	   =>'required|email|unique:members,email',
   			'nickname' =>'required|min:2|unique:members,nickname',
   			'password' =>'required|min:6|confirmed'
   		]);
   		if ($validator->fails()) {
   			return redirect('admin/members/create')
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$columns=array('cellphone','email','nickname','password','question','answer','remember_token','actived');
   			$members=array();
   			foreach ($columns as $column){
   				switch ($column){
   					case 'password':$members[$column]=bcrypt($request->input($column));break;
   					default:$members[$column]=$request->input($column);
   				}
   			}
   			members::create($members);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/members');
   		}
   }
   public function destroy(Request $request){
   		if(null!==$request->input('selected') && is_array($request->input('selected'))){
   			foreach ($request->input('selected') as $v){
   				members::where("id","=",$v)->delete();
   			}
   		}
   		$request->session()->flash('success', trans("common.operate_success"));
   		return redirect('admin/members');
   }
   public function delete($id){
	   	members::where("id","=",(int)$id)->delete();
	   	$json=array('status'=>true,'success'=>trans("common.operate_success"));
	   	echo json_encode($json);
   }
}
