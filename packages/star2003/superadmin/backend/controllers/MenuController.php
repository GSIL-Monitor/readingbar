<?php

namespace Superadmin\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Superadmin\Backend\Models\Menu;
use Validator;
class MenuController extends Controller
{
   private $breadcrumbs=array(
   		array('name'=>'menu.home','url'=>'admin','active'=>false),
   		array('name'=>'menu.system','url'=>'','active'=>false),
   		array('name'=>'menu.head_title','url'=>'admin/menu','active'=>true),
   );
   public function index(){
   		$data['head_title']=trans('menu.head_title');
   		$data['breadcrumbs']=$this->breadcrumbs;
   		$data['columns']=array('id','pre_id','name','access','url','rank','status','display','icon','created_at','updated_at');
   		$data['menus'] = menu::select($data['columns'])->paginate(15);
   		$data['success'] = session('success')?session('success'):'';
   		$data['error'] = session('error')?session('error'):'';
   		return view("superadmin/backend::menu.menu_list",$data);
   }
   public function show(){}
   public function edit($id){
   		return $this->getForm($id);
   }
   public function create(){
   		return $this->getForm();
   }
   public function getForm($id=0){
   		$data['head_title']=trans('menu.head_title');
   		$data['breadcrumbs']=$this->breadcrumbs;
   		if($id){
   			$data['action']="admin/menu/$id";
   			$data['method']="PUT";
   			$data['menu']=menu::where('id','=',$id)->first();
   		}else{
   			$data['action']="admin/menu";
   			$data['method']="POST";
   		}
   		return view("superadmin/backend::menu.menu_form",$data);
   }
   public function update(Request $request){
   		$columns=array('pre_id','rank','name','access','url','status','display','icon');
   		$id=(int)$request->input('id');
   		$validator = Validator::make($request->all(), [
   					'id'	=>'required|in:menues,id,'.$id,
   					'name' => 'required|unique:menues,id,'.$id.'|min:2',
   					'access' => 'required|unique:menues,id,'.$id,
   		]);
   		if ($validator->fails()) {
   			return redirect("admin/menu/$id/edit")
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$menu=array();
   			foreach ($columns as $column){
   				switch ($column){
   					default:$menu[$column]=$request->input($column);
   				}
   			}
   			menu::where("id","=",$id)->update($menu);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/menu');
   		}
   		
   }
   public function store(Request $request){
   		//校验
   		$validator = Validator::make($request->all(), [
   			'name' => 'required|unique:menues|min:2',
   			'access' => 'required|unique:menues',
   		]);
   		if ($validator->fails()) {
   			return redirect('admin/menu/create')
   			->withErrors($validator)
   			->withInput();
   		}else{
   			//执行
   			$columns=array('pre_id','rank','name','access','url','status','display','icon');
   			$menu=array();
   			foreach ($columns as $column){
   				switch ($column){
   					default:$menu[$column]=$request->input($column);
   				}
   			}
   			menu::create($menu);
   			$request->session()->flash('success', trans("common.operate_success"));
   			return redirect('admin/menu');
   		}
   }
   public function destroy(Request $request){
   		if(null!==$request->input('selected') && is_array($request->input('selected'))){
   			foreach ($request->input('selected') as $v){
   				menu::where("id","=",$v)->delete();
   			}
   		}
   		$request->session()->flash('success', trans("common.operate_success"));
   		return redirect('admin/menu');
   }
   
}
