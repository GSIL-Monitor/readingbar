<?php

namespace Superadmin\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Superadmin\Backend\Models\User;
use Superadmin\Backend\Models\Role;
use Validator;
class UserController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'user.head_title','url'=>'admin/user','active'=>true),
	);
   public function index(){
	   	$data['head_title']=trans('user.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		$data['columns']=array('id','name','avatar','email','role','created_at','updated_at');
   		$data['users'] = User::select($data['columns'])->paginate(15);
   		$data['roles']=array();
   		foreach (Role::get(array('id','name')) as $role){
   			$data['roles'][$role["id"]]=$role['name'];
   		}
   		$data['success'] = session('success')?session('success'):'';
   		$data['error'] = session('error')?session('error'):'';
   		return view("superadmin/backend::user.users_list",$data);
   }
   public function show(){}
   public function edit($id){
   		return $this->getForm($id);
   }
   public function create(){
   		return $this->getForm();
   }
   public function getForm($id=0){
	   	$data['head_title']=trans('user.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		if($id){
   			$data['action']="admin/user/$id";
   			$data['method']="PUT";
   			$data['user']=User::where('id','=',$id)->first();
   		}else{
   			$data['action']="admin/user";
   			$data['method']="POST";
   		}
   		$data['roles']=Role::get(array('id','name'));
   		return view("superadmin/backend::user.users_form",$data);
   }
   public function update(Request $request){
   		$columns=array("name","email","role","password");
   		$id=(int)$request->input('id');
   		if($request->input('password_confirmation')!=''){ 			//修改密码
   			$validator = Validator::make($request->all(), [
   					'id'	=>'required|in:users,id,'.$id,
   					'name' => 'required|unique:users,id,'.$id.'|min:2',
   					'email' => 'required|email|max:255|unique:users,id,'.$id.'',
   					'password' => 'required|min:6|confirmed'
   			]);
   		}else{ 														//不修改密码
   			$validator = Validator::make($request->all(), [
   					'id'	=>'required|in:users,id,'.$id,
   					'name' => 'required|unique:users,id,'.$id.'|min:2',
   					'email' => 'required|email|max:255|unique:users,id,'.$id.''
   			]);
   			$columns=array("name","email","role");
   		}
   		if ($validator->fails()) {
   			return redirect("admin/user/$id/edit")
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$user=array();
   			foreach ($columns as $column){
   				switch ($column){
   					case "password":$user[$column]=bcrypt($request->input($column));break;
   					default:$user[$column]=$request->input($column);
   				}
   			}
   			User::where("id","=",$id)->update($user);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/user');
   		}
   		
   }
   public function store(Request $request){
   		$columns=array("name","email","role","password");
   		//校验
   		$validator = Validator::make($request->all(), [
   			'name' => 'required|unique:users|min:2',
   			'email' => 'required|email|max:255|unique:users',
   			'password' => 'required|min:6|confirmed'
   		]);
   		if ($validator->fails()) {
   			return redirect('admin/user/create')
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			
   			$user=array();
   			foreach ($columns as $column){
   				switch ($column){
   					case "password":$user[$column]=bcrypt($request->input($column));break;
   					default:$user[$column]=$request->input($column);
   				}
   			}
   			User::create($user);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/user');
   		}
   }
   public function delete($id,Request $request){
	   	User::where("id","=",(int)$id)->delete();
	   	$request->session()->flash('success', trans("common.operate_success"));
	   	return redirect()->back();
   }
}
