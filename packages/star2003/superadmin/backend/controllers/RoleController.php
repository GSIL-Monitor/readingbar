<?php

namespace Superadmin\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Superadmin\Backend\Models\Role;
use Superadmin\Backend\Models\Access;
use Validator;
use Cache;
class RoleController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'role.head_title','url'=>'admin/role','active'=>true),
	);
   public function index(){
	   	$data['head_title']=trans('role.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		$data['columns']=array('id','name','created_at','updated_at');
   		$data['roles'] = Role::select($data['columns'])->paginate(15);
   		$data['success'] = session('success')?session('success'):'';
   		$data['error'] = session('error')?session('error'):'';
   		return view("superadmin/backend::role.role_list",$data);
   }
   public function show(){}
   public function edit($id){
   		return $this->getForm($id);
   }
   public function create(){
   		return $this->getForm();
   }
   public function getForm($id=0){
	   	$data['head_title']=trans('role.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		if($id){
   			$data['action']="admin/role/$id";
   			$data['method']="PUT";
   			$data['role']=Role::where('id','=',$id)->first();
   			$role_accesses=Unserialize($data['role']['attributes']['accesses']);
   		}else{
   			$data['action']="admin/role";
   			$data['method']="POST";
   		}
   		$data['accesses']=Access::get();
   		if(isset($role_accesses) && $role_accesses){
   			foreach ($data['accesses'] as $key=>$value){
   				if(in_array($value['access'],$role_accesses)){
   					$data['accesses'][$key]['selected']=true;
   				}else{
   					$data['accesses'][$key]['selected']=false;
   				}
   			}
   		}
   		return view("superadmin/backend::role.role_form",$data);
   }
   public function update(Request $request){
   		$columns=array("name","accesses");
   		$id=(int)$request->input('id');
   		$validator = Validator::make($request->all(), [
   					'id'	=>'required|in:roles,id,'.$id,
   					'name' => 'required|unique:roles,id,'.$id.'|min:2'
   		]);
   		if ($validator->fails()) {
   			return redirect("admin/role/$id/edit")
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$role=array();
   			foreach ($columns as $column){
   				switch ($column){
   					case "accesses":$role[$column]=serialize($request->input($column));break;
   					default:$role[$column]=$request->input($column);
   				}
   			}
   			Role::where("id","=",$id)->update($role);
   			//更新时去除菜单缓存
   			Cache::forget('menu_role_'.$id);
   			//更新时去除权限缓存
   			Cache::forget('role_'.$id);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/role');
   		}
   		
   }
   public function store(Request $request){
   		//校验
   		$validator = Validator::make($request->all(), [
   			'name' => 'required|unique:roles|min:2'
   		]);
   		if ($validator->fails()) {
   			return redirect('admin/role/create')
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$columns=array("name","accesses");
   			$role=array();
   			foreach ($columns as $column){
   				switch ($column){
   					case "accesses":$role[$column]=serialize($request->input($column));break;
   					default:$role[$column]=$request->input($column);
   				}
   			}
   			$accesses=$role['accesses'];
   			$role=json_decode(Role::create($role));
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/role');
   		}
   }
   public function destroy(Request $request){
   		if(null!==$request->input('selected') && is_array($request->input('selected'))){
   			foreach ($request->input('selected') as $v){
   				Role::where("id","=",$v)->delete();
   			}
   		}
   		$request->session()->flash('success', trans("common.operate_success"));
   		return redirect('admin/role');
   }

}
