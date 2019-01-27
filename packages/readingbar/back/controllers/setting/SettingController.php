<?php
namespace Readingbar\Back\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\Setting;

class SettingController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'setting.head_title','url'=>'admin/setting','active'=>true),
	);
	/**
	 * 网站设置列表
	 */
	public function settingList(){
		$data['head_title']=trans('setting.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('setting.settingList', $data);
	}
	/**
	 * 获得所有公告信息
	 * @param Request $request
	 */
	public function getSettings(Request $request){
		if((int)$request->input('limit')){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		if($request->input('sort') && in_array($request->input('sort'),['desc','asc'])){
			$sort=(int)$request->input('sort');
		}else{
			$sort='asc';
		}
		if($request->input('order') && in_array($request->input('order'),['id','created_at'])){
			$order=(int)$request->input('order');
		}else{
			$order='id';
		}
		$ns=Setting::paginate($limit);
		return $ns;
	}
	/**
	 * 编辑设置信息
	 * @param Request $request
	 */
	public function editSetting(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
			'id'		=>'required|exists:setting,id',
			'value'		=>'required'
		]);
		if($check->passes()){
			$update=array(
					'value'		=>$request->input('value')
			);
			Setting::where(['id'=>$request->input('id')])->update($update);
			return array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$errors=$check->messages()->toArray();
			return array('status'=>false,'errors'=>$errors);
		}
	}
}
?>