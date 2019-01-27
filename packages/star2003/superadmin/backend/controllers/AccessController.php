<?php

namespace Superadmin\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Superadmin\Backend\Models\Access;
use Validator;
class AccessController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'access.head_title','url'=>'admin/access','active'=>true),
	);
   public function index(){
	   	$data['head_title']=trans('access.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		$data['columns']=array('id','name','access','created_at','updated_at');
   		$data['accesss'] = Access::select($data['columns'])->paginate(15);
   		$data['success'] = session('success')?session('success'):'';
   		$data['error'] = session('error')?session('error'):'';
   		return view("superadmin/backend::access.access_list",$data);
   }
   public function show(){}
   public function edit($id){
   		return $this->getForm($id);
   }
   public function create(){
   		return $this->getForm();
   }
   public function getForm($id=0){
	   	$data['head_title']=trans('access.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		if($id){
   			$data['action']="admin/access/$id";
   			$data['method']="PUT";
   			$data['access']=Access::where('id','=',$id)->first();
   		}else{
   			$data['action']="admin/access";
   			$data['method']="POST";
   		}
   		return view("superadmin/backend::access.access_form",$data);
   }
   public function update(Request $request){
   		$columns=array("name");
   		$id=(int)$request->input('id');
   		$validator = Validator::make($request->all(), [
   					'id'	=>'required|in:accesses,id,'.$id,
   					'name' => 'required|unique:accesses,id,'.$id.'|min:2',
   					'access' => 'required|unique:accesses,id,'.$id.'|min:2'
   		]);
   		if ($validator->fails()) {
   			return redirect("admin/access/$id/edit")
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$access=array();
   			foreach ($columns as $column){
   				switch ($column){
   					default:$access[$column]=$request->input($column);
   				}
   			}
   			Access::where("id","=",$id)->update($access);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/access');
   		}
   		
   }
   public function store(Request $request){
   		//校验
   		$validator = Validator::make($request->all(), [
   			'name' => 'required|unique:accesses|min:2',
   			'access' => 'required|unique:accesses|min:2'
   		]);
   		if ($validator->fails()) {
   			return redirect('admin/access/create')
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$columns=array("name","access");
   			$access=array();
   			foreach ($columns as $column){
   				switch ($column){
   					default:$access[$column]=$request->input($column);
   				}
   			}
   			Access::create($access);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/access');
   		}
   }
   public function destroy(Request $request){
   		if(null!==$request->input('selected') && is_array($request->input('selected'))){
   			foreach ($request->input('selected') as $v){
   				Access::where("id","=",$v)->delete();
   			}
   		}
   		$request->session()->flash('success', trans("common.operate_success"));
   		return redirect('admin/access');
   }
   
}
