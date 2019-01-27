<?php
namespace Readingbar\Back\Controllers\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\ProductExtraPrice;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\District;
use Readingbar\Back\Models\ProductExtraPriceType;
class ProductExtraPriceController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'productExtraPrice.head_title','url'=>'admin/PEP','active'=>true),
	);
	/**
	 * 产品附加价格列表
	 */
	public function PEPList(){
		$data['head_title']=trans('productExtraPrice.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('product.PEPList', $data);
	}
	/**
	 * 产品附加价格表单
	 * @param Integer $id
	 */
	public function PEPForm($id=null){
		$data['head_title']=trans('productExtraPrice.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['PEP_id']=$id;
		return $this->view('product.PEPForm', $data);
	}
	/**
	 * 获得所有产品附加价格信息
	 * @param Request $request
	 */
	public function getPEPs(Request $request){
		if((int)$request->input('limit')){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		if($request->input('sort') && in_array($request->input('sort'),['desc','asc'])){
			$sort=(int)$request->input('sort');
		}else{
			$sort='desc';
		}
		if($request->input('PEP') && in_array($request->input('PEP'),['id','created_at'])){
			if(in_array($request->input('PEP'),['id','created_at'])){
				$PEP='PEP.'.$request->input('PEP');
			}
		}else{
			$PEP='PEP.id';
		}
		if($request->input('status') && in_array($request->input('status'),['0','1'])){
			$status=(int)$request->input('status');
		}else{
			$status='1';
		}
		$rs=ProductExtraPrice::leftjoin('products as p','p.id','=','product_extra_price.product_id')
			->leftjoin('product_extra_price_type as pept','pept.id','=','product_extra_price.type')
			->select(['product_extra_price.*','pept.name as type_name','p.product_name','p.price','p.deposit'])
			->paginate($limit);
		foreach ($rs as $k=>$v){
			$rs[$k]['edit']=url('admin/product/PEP/'.$v->id.'/form');
			$rs[$k]['status']=$v->status?"启用":"停用";
		}
		return $rs;
	}
	/**
	 * 根据id获取产品附加价格信息
	 * @param Request $request
	 */
	public function getPEP(Request $request){
		 $r=ProductExtraPrice::where(['id'=>$request->input('PEP_id')])->first();
		 $r['areas']=explode(',',$r['areas']);
		 return $r;
	}
	/**
	 * 编辑产品附加价格信息
	 * @param Request $request
	 */
	public function editPEP(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
			'id'				=>'required|exists:product_extra_price,id',
			'product_id'		=>'required|exists:products,id',
			'name'				=>'required',
			'extra_price'		=>'required',
			'type'				=>'required|exists:product_extra_price_type,id',
			'areas'				=>'required|array',
			'memo'				=>'required',
			'status'			=>'required|in:0,1'
		]);
		if($check->passes()){
			$update=array(
				'product_id'	=>$inputs['product_id'],
					'name'			=>$inputs['name'],
					'extra_price'	=>$inputs['extra_price'],
					'type'			=>$inputs['type'],
					'areas'			=>implode(',',$inputs['areas']),
					'memo'			=>$inputs['memo'],
					'status'		=>$inputs['status'],
			);
			ProductExtraPrice::where(['id'=>$request->input('id')])->update($update);
			return array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$errors=$check->messages()->toArray();
			return array('status'=>false,'errors'=>$errors);
		}
	}
	/**
	 * 新增产品附加价格信息
	 * @param Request $request
	 */
	public function createPEP(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
				'product_id'		=>'required|exists:products,id',
				'name'				=>'required',
				'extra_price'		=>'required',
				'type'				=>'required|exists:product_extra_price_type,id',
				'areas'				=>'required|array',
				'memo'				=>'required',
				'status'			=>'required|in:0,1'
		]);
		if($check->passes()){
			$create=array(
					'product_id'	=>$inputs['product_id'],
					'name'			=>$inputs['name'],
					'extra_price'	=>$inputs['extra_price'],
					'type'			=>$inputs['type'],
					'areas'			=>implode(',',$inputs['areas']),
					'memo'			=>$inputs['memo'],
					'status'		=>$inputs['status'],
			);
			ProductExtraPrice::create($create);
			return array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$errors=$check->messages()->toArray();
			return array('status'=>false,'errors'=>$errors);
		}
		
	}
	/**
	 * 删除产品附加价格信息
	 * @param Request $request
	 */
	public function deletePEP(Request $request){
		$json=array('status'=>false,'error'=>'功能尚未完成！');
		if($request->input('selected') && is_array($request->input('selected'))){
			ProductExtraPrice::whereIn('id',$request->input('selected'))->delete();
			$json=array('status'=>true,'success'=>'数据已删除！');
		}else{
			$json=array('status'=>false,'error'=>'请选择要删除的数据！');
		}
		return $json;
	}
	/**
	 * 获取表单所用参数
	 */
	public function getFormPar(){
		$data['products']=Products::get(['id','product_name']);
		$data['types']=ProductExtraPriceType::get(['id','name']);
		$data['areas']=District::where(['rank'=>1])->whereNotIn('id',[710000,810000,820000])->get(['name']);
		return $data;
	}
}
?>