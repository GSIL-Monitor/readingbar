<?php

namespace Readingbar\Front\Controllers\Spoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;
use DB;
use Validator;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\PointProduct;
class ShoppingCartController extends FrontController
{
	private $cart=array();
	public function __construct(){
			$cart=DB::table('s_point_member_cart')
				->where(['member_id'=>auth('member')->getId()])
				->first();
			if($cart){
				$this->cart=unserialize($cart->cart);
			}else{
				DB::table('s_point_member_cart')->insert(['member_id'=>auth('member')->getId(),'cart'=>serialize($this->cart)]);
			}
	}
	/*购物车列表*/
	public function index(){
		$data['head_title']='购物车';
		return $this->view('spoint.cartInfo',$data);
	}
	/*购物车添加商品*/
	public function add(Request $request){
		$inputs=$request->all();
		$rules=[
				'product_id'=>'required|exists:s_point_product,id,status,1,del,0',
				'quantity' =>'required|integer|min:1'
		];
		$messages=trans('PointCart.messages');
		$check=Validator::make($inputs,$rules,$messages);
		if($check->passes()){
			$product=PointProduct::where(['id'=>$request->input('product_id')])->first();
			if($product->quantity>=$request->input('quantity')){
				$this->cart[$request->input('product_id')]=array('product_id'=>$request->input('product_id'),'quantity'=>$request->input('quantity'),'pay_status'=>true);
				$this->save_database();
				$return= array('status'=>true,'success'=>'产品已加入购物车！');
			}else{
				$return=array('status'=>false,'error'=>'产品数量不足,无法加入购物车！');
			}
		}else{
			$return=array('status'=>false,'error'=>$check->errors()->first());
		}
		return $return;
	}
	/*修改购车商品数量*/
	public function update(Request $request){
		$inputs=$request->all();
		$rules=[
				'product_id'=>'required|exists:s_point_product,id,status,1,del,0',
				'quantity' =>'required|integer|min:1',
				'pay_status'=>'in:false,true,0,1'
		];
		$messages=trans('PointCart.messages');
		$check=Validator::make($inputs,$rules,$messages);
		
		if($check->passes()){
			$product=PointProduct::where(['id'=>$request->input('product_id')])->first();
			if($product->quantity>=$request->input('quantity')){
				$this->cart[$request->input('product_id')]=array('product_id'=>$request->input('product_id'),'quantity'=>$request->input('quantity'),'pay_status'=>$request->input('pay_status')=='true'||$request->input('pay_status')=='1'?true:false);
				$this->save_database();
				return array('status'=>true,'success'=>'产品已加入购物车！');
			}else{
				$this->cart[$request->input('product_id')]=array('product_id'=>$request->input('product_id'),'quantity'=>$product->quantity,'pay_status'=>$request->input('pay_status')=='true'||$request->input('pay_status')=='1'?true:false);
				$this->save_database();
				return array('status'=>true,'success'=>'产品数量不足,购买数量已调整至该产品的最大值！');
			}
		}else{
			return array('status'=>false,'error'=>$check->errors()->first());
		}
	}
	/*移除某个商品*/
	public function remove(Request $request){
		$inputs=$request->all();
		$rules=[
				'product_id'=>'required'
		];
		$messages=trans('PointCart.messages');
		$check=Validator::make($inputs,$rules,$messages);
		if($check->passes()){
			if($this->hasProduct($request->input('product_id'))){
				unset($this->cart[$request->input('product_id')]);
				$this->save_database();
				return array('status'=>true,'success'=>'该产品已从购物车中移除！');
			}else{
				return array('status'=>false,'error'=>'购物车中不存在该产品！');
			}
		}else{
			return array('status'=>false,'error'=>$check->errors()->first());
		}
	}
	/*商品全选*/
	public function selectAll(Request $request){
		foreach ($this->cart as $k=>$v){
			$this->cart[$k]['pay_status']=$request->input('selectAll')=='true'?true:false;
		}
		$this->save_database();
		return array('status'=>true,'success'=>'状态已修改！');
	}
	/*清空购物车*/
	public function clear(){
		$this->cart=array();
		$this->save_database();
	}
	/*购物车存储数据库*/
	public function save_database(){
		DB::table('s_point_member_cart')->where(['member_id'=>auth('member')->getId()])->update(['cart'=>serialize($this->cart)]);
	}
	/*外部调用购物车信息*/
	public function getCart(){
		$total_product=0;
		$pay_total_product=0;
		$unpay_total_product=0;
		$total_points=0;
		$pay_cart_status=true;
		$products=array();
		$collectionID=CollectionController::getCollectionPID();
		foreach ($this->cart as $p){
				$product=PointProduct::where(['id'=>$p['product_id'],'del'=>0,'status'=>1])->first();
				if($product){
					$total_product+=$p['quantity'];
					if($p['pay_status']){
						$pay_total_product+=$p['quantity'];
						$total_points+=$product->point*$p['quantity'];
					}else{
						$unpay_total_product+=$p['quantity'];
					}
					if($product->quantity>=$p['quantity']){
						$msg=null;
					}else{
						$msg='库存不足!';
						$pay_cart_status=false;
					}
					$products[]=[
							'product_id'=>$product->id,
							'point'=>$product->point,
							'product_name'=>$product->product_name,
							'image'=>url($product->image),
							'desc'=>$product->desc,
							'type'=>$product->type,
							'type_v'=>$product->type_v,
							'quantity'=>$p['quantity'],
							'stock_quantity'=>$product->quantity,
							'pay_status'=>(int)$p['pay_status'],
							'msg'=>$msg,
							'collection_status'=>in_array($product->id,$collectionID)
					];
				}
		}
		$return=[
				'total_product'=>$total_product,
				'pay_total_product'=>$pay_total_product,
				'unpay_total_product'=>$unpay_total_product,
				'total_points'=>$total_points,
				'products'=>$products,
				'pay_cart_status'=>$pay_cart_status
		];
		return $return;
	}
	/*校验是否有某个商品*/
	public function hasProduct($product_id){
		if($product_id){
			if(isset($this->cart[$product_id])){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/*获取加入购物车的商品Id*/
	static function getCartPID(){
		$pid=[];
		$cart=DB::table('s_point_member_cart')
					->where(['member_id'=>auth('member')->getId()])
					->first();
		if($cart){
			$cart=unserialize($cart->cart);
		}else{
			DB::table('s_point_member_cart')->insert(['member_id'=>auth('member')->getId(),'cart'=>serialize([])]);
			$cart=[];
		}
		foreach ($cart as $p){
			$pid[]=$p['product_id'];
		}
		return $pid;
	}
}
