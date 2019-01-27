<?php

namespace Readingbar\Front\Controllers\Spoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;
use DB;
use Readingbar\Back\Models\PointProduct;
use Readingbar\Back\Models\PPC;
use Hamcrest\Text\SubstringMatcher;
class ProductController extends FrontController
{
	/*产品列表*/
	public function index(){
		$data['head_title']='商城';
		$data['catagory']=PPC::where(['del'=>0])
		->get()
		->each(function($item){
			$item->icon_pc_style= $item->icon_pc?"background-image:url('".url($item->icon_pc)."')" :"";
			$item->icon_wap=$item->icon_wap?url($item->icon_wap) :"";
			return $item;
		})->toJson();
		//dd($data['catagory']);
		return $this->view('spoint.productList',$data);
	}
	/*产品详情*/
	public function detail(Request $request){
		$data['head_title']='产品详情';
		$product=PointProduct::where(['del'=>0,'status'=>1,'id'=>$request->input("product_id")])
			->select(['s_point_product.*','s_point_product.quantity as stock_quantity'])
			->first();
		if($product){
			$collectionID=CollectionController::getCollectionPID();
			$shoppingCartID=ShoppingCartController::getCartPID();
			$product['image']=url($product['image']);
			$product['quantity']=1;
			$product['serial']=substr((string)($product['id']+10000),1,4);
			$product['collection_status']=in_array($product['id'],$collectionID);
			$product['shoppingcart_status']=in_array($product['id'],$shoppingCartID);
		}
		
		$data['product']=collect($product?$product:[])->toJson();
		return $this->view('spoint.productDetail',$data);
	}
	/*获取产品*/
	public function getProducts(Request $request){
		$return=PointProduct::where(['del'=>0,'status'=>1])
		->where(function($where) use($request){
				if($request->input('catagory_id')){
					$where->where(['catagory'=>$request->input('catagory_id')]);
				}
		})->orderBy(
				$request->input('order') && in_array($request->input('order'),['id','point'])?$request->input('order'):'id',
				$request->input('sort') && in_array($request->input('sort'),['asc','desc'])?$request->input('sort'):'desc'
		)->select(['s_point_product.*','s_point_product.quantity as stock_quantity'])
		->paginate($request->input('limit')?$request->input('limit'):5)
		->toArray();
		$collectionID=CollectionController::getCollectionPID();
		$shoppingCartID=ShoppingCartController::getCartPID();
		foreach ($return['data'] as $k=>$v){
			$return['data'][$k]['image']=url($v['image']);
			$return['data'][$k]['quantity']=1;
			$return['data'][$k]['serial']=substr((string)($v['id']+10000),1,4);
			$return['data'][$k]['collection_status']=in_array($v['id'],$collectionID);
			$return['data'][$k]['shoppingcart_status']=in_array($v['id'],$shoppingCartID);
			$return['data'][$k]['detail']=url("member/spoint/product/detail?product_id=".$v['id']);
		}
		return $return;
	}
}
