<?php
namespace Readingbar\Back\Controllers\Product;

use Readingbar\Back\Controllers\BackController;
use Readingbar\Back\Models\ProductRenewDiscount;
use Illuminate\Http\Request;
use Readingbar\Back\Models\Products;
use Validator;
use Readingbar\Back\Models\Services;

class ProductRenewDiscountController extends BackController{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'ProductRenewDiscount.head_title','url'=>'admin/PEP','active'=>true),
	);
	public function index(Request $request) {
		$result=ProductRenewDiscount::where(function ($where) use($request) {
			if ($request->input('product_id')) {
				$where->where([
						'product_id'=>$request->input('product_id')
				]);
			}
		})
		->paginate(10);
		if($request->ajax()){
			return ['data'=>$result,'message'=>'数据获取成功'];
		}else{
			$data['head_title']=trans('ProductRenewDiscount.head_title');
			$data['breadcrumbs']=$this->breadcrumbs;
			$data['data']=$result;
			$data['products'] = Products::get([
					'id as value',
					'product_name as text'
			]);
			return $this->view('product.renewDiscountList', $data);
		}
	}
	public function show() {
	
	}
	public function create(){
		$data['head_title']=trans('ProductRenewDiscount.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['products'] = Products::get([
				'id as value',
				'product_name as text'
		]);
		$data['services'] = Services::get([
				'id as value',
				'service_name as text'
		]);
		return $this->view('product.renewDiscountForm', $data);
	}
	public function edit($id){
		$data['head_title']=trans('ProductRenewDiscount.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['products'] = Products::get([
				'id as value',
				'product_name as text'
		]);
		$data['services'] = Services::get([
				'id as value',
				'service_name as text'
		]);
		$data['data']=ProductRenewDiscount::where(['id'=>$id])->first();
		if ($data['data']){
			$data['data']->services = $data['data']->services?unserialize($data['data']->services):[];
			return $this->view('product.renewDiscountForm', $data);
		}
		return redirect(url('admin/productRenewDiscount'))->with(['alert'=>'数据不存在！']);
	}
	public function store(Request $request){
		$check = Validator::make($request->all(),$this->getRulesByType($request));
		if ($check->passes()) {
			$data = $this->getWillDoData($request);
			$result = ProductRenewDiscount::create($data);
			return ['data'=>$result,'message'=>'数据已保存！'];
		}else{
			return response($check->errors(),400);
		}
	}
	public function update($id,Request $request){
		$rules = $this->getRulesByType($request);
		$rules['id']='required|exists:product_renew_discount,id';
		$check = Validator::make($request->all(),$rules);
		if ($check->passes()) {
			$data = $this->getWillDoData($request);
			$result = ProductRenewDiscount::where(['id'=>$request->input('id')])->update($data);
			return ['data'=>$result,'message'=>'数据已保存！'];
		}else{
			return response($check->errors(),400);
		}
	}
	private function getRulesByType ($request) {
		$rules = [];
		switch ($request->input('type')) {
			case 1: $rules = [
					'services'=>'required|array'
			];
			break;
			case 2: $rules = [
					'service_id'=>'required|exists:services,id',
					'days'=>'required|integer|min:1'
			];break;
			case 3: $rules = [
				'product'=>'required|exists:products,id',
				'days'=>'required|integer|min:1'
			];break;
		}
		$rules['product_id'] = 'required|exists:products,id';
		$rules['discount_price'] = 'required|integer|min:1';
		$rules['name'] = 'required|max:255';
		$rules['type'] = 'required|in:1,2,3';
		$rules['display'] = 'required|integer|min:1';
		return $rules;
	}
	private function getWillDoData($request){
		$data = [];
		$rules = $this->getRulesByType($request);
		foreach ($rules as $key=>$val){
			if ($key === 'services') {
				$data[$key] = serialize($request->input($key));
			}else{
				$data[$key] = $request->input($key);
			}
		}
		return $data;
	}
	public function destroy($id){
		$d=ProductRenewDiscount::where(['id'=>$id])->first();
		if ($d) {
			ProductRenewDiscount::where(['id'=>$id])->delete();
			return ['message'=>'数据删除成功'];
		}else{
			return response('数据不存在或者已删除！',400);
		}
	}
}