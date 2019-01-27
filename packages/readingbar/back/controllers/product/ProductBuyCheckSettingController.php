<?php 
namespace Readingbar\Back\Controllers\Product;

use App\Http\Controllers\Controller;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\ProductBuyCheck;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Illuminate\Http\Request;
use Readingbar\Back\Models\Services;
class ProductBuyCheckSettingController extends BackController{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'ProjectBuyCheckSetting.head_title','url'=>'admin/PEP','active'=>true),
	);
	public function productList(Request $request){
		$data['head_title']=trans('ProjectBuyCheckSetting.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('product.productList', $data);
	}
	public function productPreBuyRuleList($id){
		$data['head_title']=trans('ProjectBuyCheckSetting.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['product_id']=$id;
		$data['error'] = session('error')?session('error'):null;
		session('error',null);
		return $this->view('product.productPreCheckRuleList', $data);
	}
	public function RuleFormCreate($id){
		$data['head_title']=trans('ProjectBuyCheckSetting.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['product_id']=$id;
		$data['services'] = Services::get(['service_name as text','id as value'])->toJson();
		return $this->view('product.productPreCheckRuleForm', $data);
	}
	public function RuleFormEdit($id){
		$data['head_title']=trans('ProjectBuyCheckSetting.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['object']=ProductBuyCheck::where(['id'=>$id])->first();
		$data['services'] = Services::get(['service_name as text','id as value'])->toJson();
		if ($data['object']) {
			$data['object']['array']=$data['object']['array']?unserialize($data['object']['array']):[];
			$data['object']=$data['object']->toJson();
			return $this->view('product.productPreCheckRuleForm', $data);
		}else{
			return redirect()->back()->with('error','记录不存在！');
		}
	}
	public function getProductList(Request $request){
		return Products::select(['id','product_name','show'])->paginate(10);
	}
	public function getProductPreBuyRuleList(Request $request){
		$check = Validator::make($request->all(),[
				'product_id'=>'required|exists:products,id'
		],[],[
				'product_id'=>'产品'
		]);
		if ($check->passes()) {
			$result = ProductBuyCheck::where(['product_id'=>$request->input('product_id')])->paginate(10);
			foreach ($result as $v) {
				$v->product_name = Products::where(['id'=>$request->input('product_id')])->first()->product_name;
			}
			return $result;
		}else{
			return response($check->errors()->first(),400);
		}
	}
	public function getProductPreBuyRuleById(Request $request){
		$check = Validator::make($request->all(),[
				'id'=>'required|exists:product_buy_check,id'
		]);
		if ($check->passes()) {
			return ProductBuyCheck::where(['id'=>$request->input('id')])->paginate(10);
		}else{
			return response($check->errors()->first(),400);
		}
	}
	public function store(Request $request){
		$check = Validator::make($request->all(),$this->getValidatorRule($request));
		if ($check->passes()) {
			$result = ProductBuyCheck::create($this->getWillSaveData($request));
			return $result;
		}else{
			return response($check->errors(),400);
		}
	}
	public function update(Request $request){
		$rules = $this->getValidatorRule($request);
		$rules['id']='required|exists:product_buy_check,id';
		$check = Validator::make($request->all(),$rules);
		if ($check->passes()) {
			$result = ProductBuyCheck::where(['id'=>$request->input('id')])->update($this->getWillSaveData($request));
			return $result;
		}else{
			return response($check->errors(),400);
		}
	}
	public function destroy(Request $request){
		$check = Validator::make($request->all(),[
				'id'=>'required|exists:product_buy_check,id'
		]);
		if ($check->passes()) {
			ProductBuyCheck::where(['id'=>$request->input('id')])->delete();
			return ['success'=>true,'message'=>'数据已删除！'];
		}else{
			return response($check->errors()->first(),400);
		}
	}
	/**
	 * 产品购买校验规则
	 * 1.必须拥有的前置服务校验
	 * 2.不能拥有的前置服务校验
	 * 3.未做过测试报告
	 * 4.有未完成的借阅计划
	 * 5.产品不可购买
	 * 6.GE值是否达标
	 * 7.曾购买过任意产品
	 * @param Request $request
	 */
	private function getValidatorRule(Request $request){
		$rules = [];
		switch($request->input('type')){
			case 1: //必须拥有的前置服务校验
			case 2: //不能拥有的前置服务校验
				$rules = [
					'array'=>'required|array',
					'message'=>'required|max:255'
				];
				break;
			case 3: //未做过测试报告
				$rules = [
						'message'=>'required|max:255'
				];
				break;
			case 4:
				break;
			case 5:
				$rules = [
						'message'=>'required|max:255'
				];
				break;
			case 6:
				$rules = [
					'number'=>'required|Numeric',
					'boolean'=>'required|in:0,1',
					'message'=>'required|max:255'
				];
				break;
			case 7: 
				$rules = [
						'message'=>'required|max:255'
				];
				break;
		}
		$rules['type']='required|in:1,2,3,4,5,6,7';
		$rules['product_id']='required|exists:products,id';
		$rules['display']='required|in:1,2,3,4,5,6,7,8,9,10';
		return $rules;
	}
	private function getWillSaveData(Request $request){
		$save = [];
		foreach ($this->getValidatorRule($request) as $key=>$val) {
			if ($key == 'array') {
				$save[$key]=serialize($request->input($key)?$request->input($key):[]);
			}else{
				$save[$key] = $request->input($key);
			}
		}
		return $save;
	}
}