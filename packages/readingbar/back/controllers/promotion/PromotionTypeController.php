<?php
namespace Readingbar\Back\Controllers\Promotion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\PromotionsType;
use Readingbar\Back\Models\DiscountType;
use Readingbar\Back\Models\Products;
class PromotionTypeController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'PromotionType.head_title','url'=>'admin/PromotionType','active'=>true),
	);
	/**
	 * 列表
	 */
	public function PromotionTypeList(){
		$data['head_title']=trans('PromotionType.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('promotion.promotionTypeList', $data);
	}
	/**
	 * 表单
	 * @param Integer $id
	 */
	public function PromotionTypeForm($id=null){
		$data['head_title']=trans('PromotionType.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['PromotionType_id']=$id;
		$data['products']=Products::getEnableProducts()->toJson();
		//dd($data['products']);
		return $this->view('promotion.promotionTypeForm', $data);
	}
	/**
	 * 获得所有信息
	 * @param Request $request
	 */
	public function getPromotionTypes(Request $request){
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
		$ns=PromotionsType::selectRaw('promotions_type.*')
							->orderBy('promotions_type.id','asc')
							->paginate($limit);
		foreach ($ns as $k=>$v){
			$ns[$k]['edit']=url('admin/promotion/type/'.$v['id'].'/form');
			$ns[$k]['status']=$v['status']==1?'启用':'停用';
		}
		return $ns;
	}
	/**
	 * 根据id获取信息
	 * @param Request $request
	 */
	public function getPromotionType(Request $request){
		 $r=PromotionsType::where(['id'=>$request->input('id')])->first();
		 $r['products']=$r['products']?unserialize($r['products']):[];
		 return $r;
	}
	/**
	 * 编辑信息
	 * @param Request $request
	 */
	public function editPromotionType(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
			'id'		=>'required|exists:promotions_type,id',
			'name'		=>'required',
			'products'	=>'required|array',
		]);
		if($check->passes()){
			$update=array(
					'name'		=>$request->input('name'),
					'products'	=>serialize($request->input('products'))
			);
			PromotionsType::where(['id'=>$request->input('id')])->update($update);
			return array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$errors=$check->messages()->toArray();
			return array('status'=>false,'errors'=>$errors);
		}
	}
	/**
	 * 新增记录
	 * @param Request $request
	 */
	public function createPromotionType(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
				'name'		=>'required',
				'products'	=>'required|array',
		]);
		if($check->passes()){
			$create=array(
					'name'		=>$request->input('name'),
					'products'	=>serialize($request->input('products'))
			);
			PromotionsType::create($create);
			return array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$errors=$check->messages()->toArray();
			return array('status'=>false,'errors'=>$errors);
		}
		
	}
	/**
	 * 删除记录
	 * @param Request $request
	 */
	public function deletePromotionType(Request $request){
		if($request->input('selected') && is_array($request->input('selected'))){
			PromotionsType::whereIn('id',$request->input('selected'))->delete();
			$json=array('status'=>true,'success'=>'数据已删除！');
		}else{
			$json=array('status'=>false,'error'=>'请选择要删除的数据！');
		}
		return $json;
	}
	/**
	 * 获取表单参数
	 * @param Request $request
	 */
	public function getFormPar(){
		$data['discount_types']=DiscountType::get(['id','name']);
		return $data;
	}
}
?>