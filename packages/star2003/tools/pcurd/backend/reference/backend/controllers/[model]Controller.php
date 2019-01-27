<?php

namespace [vendor]\[ucfirst_name]\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use [vendor]\[ucfirst_name]\Backend\Models\[model];
use Validator;
class [ucfirst_model]Controller extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'[model].head_title','url'=>'admin/[model]','active'=>true),
	);
   public function index(){
	   	$data['head_title']=trans('[model].head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		$data['columns']=[list_columns];
   		$data['[model]s'] = [model]::select($data['columns'])->paginate(15);
   		$data['success'] = session('success')?session('success'):'';
   		$data['error'] = session('error')?session('error'):'';
   		return view("[vendor]/[name]/backend::[model]_list",$data);
   }
   public function show(){}
   public function edit($id){
   		return $this->getForm($id);
   }
   public function create(){
   		return $this->getForm();
   }
   public function getForm($id=0){
	   	$data['head_title']=trans('[model].head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		if($id){
   			$data['action']="admin/[model]/$id";
   			$data['method']="PUT";
   			$data['[model]']=[model]::where('id','=',$id)->first();
   		}else{
   			$data['action']="admin/[model]";
   			$data['method']="POST";
   		}
   		return view("[vendor]/[name]/backend::[model]_form",$data);
   }
   public function update(Request $request){
   		$columns=[update_columns];
   		$id=(int)$request->input('id');
   		$validator = Validator::make($request->all(), [
   					'id'	=>'required|in:[model]es,id,'.$id,
   		]);
   		if ($validator->fails()) {
   			return redirect("admin/[model]/$id/edit")
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$[model]=array();
   			foreach ($columns as $column){
   				switch ($column){
   					default:$[model][$column]=$request->input($column);
   				}
   			}
   			[model]::where("id","=",$id)->update($[model]);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/[model]');
   		}
   		
   }
   public function store(Request $request){
   		//校验
   		$validator = Validator::make($request->all(), [

   		]);
   		if ($validator->fails()) {
   			return redirect('admin/[model]/create')
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$columns=[store_columns];
   			$[model]=array();
   			foreach ($columns as $column){
   				switch ($column){
   					default:$[model][$column]=$request->input($column);
   				}
   			}
   			[model]::create($[model]);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/[model]');
   		}
   }
   public function destroy(Request $request){
   		if(null!==$request->input('selected') && is_array($request->input('selected'))){
   			foreach ($request->input('selected') as $v){
   				[model]::where("id","=",$v)->delete();
   			}
   		}
   		$request->session()->flash('success', trans("common.operate_success"));
   		return redirect('admin/[model]');
   }
   
}
