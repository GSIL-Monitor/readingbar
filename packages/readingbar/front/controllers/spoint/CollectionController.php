<?php

namespace Readingbar\Front\Controllers\Spoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;
use DB;
use Validator;
use Readingbar\Back\Models\PointProductCollection;
use Schema;
class CollectionController extends FrontController
{
	/*收藏首页*/
	public function index(){
		$data['head_title']='我的收藏';
		return $this->view('spoint.collection',$data);
	}
	/*获取收藏列表数据*/
	public function getList(Request $request){
		$return=PointProductCollection::leftjoin('s_point_product','s_point_product.id','=','s_point_product_collection.product_id')
					->where(['s_point_product_collection.member_id'=>auth('member')->id()])
					->where(function($where) use($request){
							if($request->input('keyword')){
								$where->where(['s_point_product.product_name'=>$request->input('keyword')]);
							}
					})->orderBy(
							$this->assignColumn($request->input('order')),
							$request->input('sort') && in_array($request->input('sort'),['asc','desc'])?$request->input('sort'):'desc'
					)->select(['s_point_product.*','s_point_product.quantity as stock_quantity','s_point_product.id as product_id','s_point_product_collection.id as id'])
					->paginate($request->input('limit')?$request->input('limit'):5)
					->toArray();
		$shoppingCartID=ShoppingCartController::getCartPID();
		foreach ($return['data'] as $k=>$v){
			$return['data'][$k]['image']=url($v['image']);
			$return['data'][$k]['quantity']=1;
			$return['data'][$k]['serial']=substr((string)($v['product_id']+10000),1,4);
			$return['data'][$k]['shoppingcart_status']=in_array($v['product_id'],$shoppingCartID);
		}
		return $return;
	}
	/*添加收藏*/
	public function add(Request $request){
		$inputs=$request->all();
		$rules=[
				'product_id'=>'required|exists:s_point_product,id,status,1,del,0',
		];
		$messages=trans('PointProductCollection.messages');
		$check=Validator::make($inputs,$rules,$messages);
		if($check->passes()){
			if(!PointProductCollection::where(['member_id'=>auth('member')->getId(),'product_id'=>$request->input('product_id')])->first()){
				PointProductCollection::create([
						'member_id'=>auth('member')->getId(),
						'product_id'=>$request->input('product_id')
				]);
			}
			$return =array('status'=>true,'success'=>'已加入收藏');
		}else{
			$return =array('status'=>false,'error'=>$check->errors()->first());
		}
		return $return;
	}
	/*移除收藏*/
	public function remove(Request $request){
		$inputs=$request->all();
		$rules=[
				'id'=>'required|exists:s_point_product_collection,id,member_id,'.auth('member')->getId(),
		];
		$messages=trans('PointProductCollection.messages');
		$check=Validator::make($inputs,$rules,$messages);
		if($check->passes()){
			PointProductCollection::where(['id'=>$request->input('id')])->delete();
			$return =array('status'=>true,'success'=>'收藏已移除');
		}else{
			$return =array('status'=>false,'error'=>$check->errors()->first());
		}
		return $return;
	}
	/*字段分捡*/
	public function assignColumn($column){
		if($column){
			if(in_array($column,Schema::getColumnListing('s_point_product_collection'))){
				return  's_point_product_collection.'.$column;
			}else if(in_array($column,Schema::getColumnListing('s_point_product'))){
				return  's_point_product.'.$column;
			}else{
				return  's_point_product_collection.id';
			}
		}else{
			return  's_point_product_collection.id';
		}
	}
	/*获取指定会员的积分收藏商品的ID*/
	static function getCollectionPID(){
		if(auth('member')->check()){
			return PointProductCollection::where(['member_id'=>auth('member')->getId()])->get(['product_id'])->pluck('product_id')->all();
		}else{
			return array();
		}
	}
}