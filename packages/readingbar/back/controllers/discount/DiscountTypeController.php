<?php
namespace Readingbar\Back\Controllers\Discount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\DiscountType;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\PromotionsType;
class DiscountTypeController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'DiscountType.head_title','url'=>'admin/DiscountType','active'=>true),
	);
	/**
	 * 列表
	 */
	public function DiscountTypeList(){
		$data['head_title']=trans('DiscountType.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('discount.discountTypeList', $data);
	}
	/**
	 * 表单
	 * @param Integer $id
	 */
	public function DiscountTypeForm($id=null){
		if(old()){
			$data['obj']=old();
		}else if($id){
			if($type=$this->getDiscountType($id)){
				$data['obj']=$type;
			}else{
				return redirect('admin/discount/type')->back()->with();
			}
			$data['action']=url('admin/api/discount/type/editDiscountType');
		}else{
			$data['action']=url('admin/api/discount/type/createDiscountType');
		}
		$data['head_title']=trans('DiscountType.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['products']=Products::get(['id','product_name']);
		$data['status']=trans('DiscountType.form.status');
		$data['get_rules']=trans('DiscountType.form.get_rules');
		$data['get_limits']=trans('DiscountType.form.get_limits');
		$data['donations']=trans('DiscountType.form.donations');
		$data['get_rule_promotions_types']=PromotionsType::get(['id','name']);
		$data['get_rule_products']=Products::get(['id','product_name as name']);
		return $this->view('discount.discountTypeForm', $data);
	}
	/**
	 * 获得所有信息
	 * @param Request $request
	 */
	public function getDiscountTypes(Request $request){
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
		$ns=DiscountType::where(['del'=>0])->paginate($limit);
		foreach ($ns as $k=>$v){
			$ns[$k]['edit']=url('admin/discount/type/'.$v['id'].'/form');
			$ns[$k]['get_rule']=trans('DiscountType.list.get_rules.'.$v['get_rule']);
			$ns[$k]['status']=trans('DiscountType.list.status.'.$v['status']);
		}
		return $ns;
	}
	/**
	 * 根据id获取信息
	 * @param Request $request
	 */
	public function getDiscountType($id){
		 $r=DiscountType::where(['id'=>$id])->first();
		 if($r){
		 	$r['products']=unserialize($r['products'])?unserialize($r['products']):array();
		 	$r['get_rule_products']=unserialize($r['get_rule_products'])?unserialize($r['get_rule_products']):array();
		 	$r['get_rule_promotions_types']=unserialize($r['get_rule_promotions_types'])?unserialize($r['get_rule_promotions_types']):array();
		 }
		// dd($r);
		 return $r;
	}
	/**
	 * 编辑信息
	 * @param Request $request
	 */
	public function editDiscountType(Request $request){
		$inputs=$request->all();
		$rules=[
			'id'		=>'required|exists:discount_type,id',
			'name'		=>'required',
			'price'		=>'required|integer|min:1',
			'days'		=>'required|integer|min:1',
			'products'	=>'required|array',
			'status'=>'required|in:0,1',
			'get_limit'=>'required|in:'.implode(',',collect(trans('DiscountType.form.get_limits'))->keys()->all()),
			'donation'=>'required|in:'.implode(',',collect(trans('DiscountType.form.donations'))->keys()->all()),
			'get_rule'=>'required|in:'.implode(',',collect(trans('DiscountType.form.get_rules'))->keys()->all())
		];
		$messages=trans('DiscountType.messages');
		$attributes=trans('DiscountType.attributes');
		$rules=$this->resetRules('edit', $inputs, $rules);
		$check=Validator::make($inputs,$rules,$messages,$attributes);
		if($check->passes()){
			$update=array(
					'name'		=>$request->input('name'),
					'price'		=>$request->input('price'),
					'days'		=>$request->input('days'),
					'status'		=>$request->input('status'),
					'donation'		=>$request->input('donation'),
					'products'	=>serialize($request->input('products')),
					'get_rule'	=>$request->input('get_rule'),
					'get_rule_promotions_types'	=>serialize($request->input('get_rule_promotions_types')),
					'get_rule_products'	=>serialize($request->input('get_rule_products')),
					'get_limit'		=>$request->input('get_limit'),
					'memo'		=>$request->input('memo')
			);
			DiscountType::where(['id'=>$request->input('id')])->update($update);
			return redirect('admin/discount/type')->with('success','数据已保存！');
		}else{
			return redirect()->back()->withErrors($check->errors());
		}
	}
	/**
	 * 新增记录
	 * @param Request $request
	 */
	public function createDiscountType(Request $request){
		$inputs=$request->all();
		$rules=[
				'name'		=>'required',
				'price'		=>'required|integer|min:1',
				'days'		=>'required|integer|min:1',
				'products'	=>'required|array',
				'status'=>'required|in:0,1',
				'get_limit'=>'required|in:'.implode(',',collect(trans('DiscountType.form.get_limits'))->keys()->all()),
				'donation'=>'required|in:'.implode(',',collect(trans('DiscountType.form.donations'))->keys()->all()),
				'get_rule'=>'required|in:'.implode(',',collect(trans('DiscountType.form.get_rules'))->keys()->all())
		];
		$messages=trans('DiscountType.messages');
		$attributes=trans('DiscountType.attributes');
		$rules=$this->resetRules('create', $inputs, $rules);
		$check=Validator::make($inputs,$rules,$messages,$attributes);
		if($check->passes()){
			$create=array(
					'name'		=>$request->input('name'),
					'price'		=>$request->input('price'),
					'days'		=>$request->input('days'),
					'status'		=>$request->input('status'),
					'donation'		=>$request->input('donation'),
					'products'	=>serialize($request->input('products')),
					'get_rule'	=>$request->input('get_rule'),
					'get_rule_promotions_types'	=>serialize($request->input('get_rule_promotions_types')),
					'get_rule_products'	=>serialize($request->input('get_rule_products')),
					'get_limit'		=>$request->input('get_limit'),
					'memo'		=>$request->input('memo')
			);
			DiscountType::create($create);
			return redirect('admin/discount/type')->with('success','数据已保存！');
		}else{
			return redirect()->back()->withErrors($check->errors());
		}
	}
	//动态录入校验规则
	public  function resetRules($type,$param,$rules){
		switch($type){
				case 'create':;
				case 'edit':
						//校验获取规则关联的推广员
						if(in_array($param['get_rule'],['promoted_register','become_promoter','promoted_member_buy','promote_new_member'])){
								$rules['get_rule_promotions_types']='required|array';
						}
						//校验获取规则关联的推广员
						if(in_array($param['get_rule'],['promoted_member_buy','member_buy'])){
								$rules['get_rule_products']='required|array';
						}
				break;
		}
		return $rules;
	}
	/**
	 * 删除记录
	 * @param Request $request
	 */
	public function deleteDiscountType(Request $request){
		if($request->input('selected') && is_array($request->input('selected'))){
			DiscountType::whereIn('id',$request->input('selected'))->update(['del'=>1]);
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