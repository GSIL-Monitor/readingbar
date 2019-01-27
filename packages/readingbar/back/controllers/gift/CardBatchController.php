<?php
namespace Readingbar\Back\Controllers\Gift;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Readingbar\Back\Models\Promotions;
use Readingbar\Back\Models\Members;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\Orders;
use Readingbar\Back\Models\CardBatch;
use Readingbar\Back\Models\Products;
use Validator;
use Readingbar\Back\Models\Cards;
class CardBatchController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'cardBatch.head_title','url'=>'admin/gift/cardBatch','active'=>true),
	);
	/**
	 * 礼品卡批次列表
	 */
	public function cardBatchList(){
		$data['head_title']=trans('cardBatch.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('gift.cardBatch', $data);
	}
	/**
	 * 礼品卡批次表单
	 * @param Integer $id
	 */
	public function cardBatchForm($id=null){
			$data['head_title']=trans('cardBatch.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['batch_id']=$id;
		return $this->view('gift.cardBatchForm', $data);
	}
	/**
	 * 获得所有礼品卡批次信息
	 * @param Request $request
	 */
	public function getBatches(Request $request){
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
		$cardBatches=CardBatch::leftjoin('products as p','p.id','=','card_batch.product_id')
					->selectRaw('card_batch.*,p.product_name')
					->paginate($limit);
		foreach ($cardBatches as $k=>$d){
			$cardBatches[$k]['edit']=url('admin/gift/cardBatch/'.$d['id'].'/form');
			$cardBatches[$k]['status']=$d['status']?'启用':'停用';
		}
		return $cardBatches;
	}
	/**
	 * 根据id获取礼品卡批次信息
	 * @param Request $request
	 */
	public function getBatch(Request $request){
		return CardBatch::where(['id'=>$request->input('batch_id')])->first();
	}
	/**
	 * 编辑礼品卡批次信息
	 * @param Request $request
	 */
	public function editBatch(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
			'id'		=>'required|exists:card_batch,id',
			'name'		=>'required',
			'price'		=>'required',
			'deposit'	=>'required',
			'status'	=>'required|in:0,1',
			'expired'	=>'required',
			'product_id'=>'required|exists:products,id'
		]);
		if($check->passes()){
			$update=array(
					'name'		=>$request->input('name'),
					'price'		=>$request->input('price'),
					'deposit'	=>$request->input('deposit'),
					'status'	=>$request->input('status'),
					'product_id'=>$request->input('product_id'),
					'desc'		=>$request->input('desc'),
					'expired'	=>$request->input('expired')
			);
			CardBatch::where(['id'=>$request->input('id')])->update($update);
			return array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$errors=$check->messages()->toArray();
			return array('status'=>false,'errors'=>$errors);
		}
	}
	/**
	 * 新增礼品卡批次信息
	 * @param Request $request
	 */
	public function createBatch(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
				'name'		=>'required',
				'price'		=>'required',
				'deposit'	=>'required',
				'status'	=>'required|in:0,1',
				'expired'	=>'required',
				'product_id'=>'required|exists:products,id'
		]);
		if($check->passes()){
			$create=array(
					'name'		=>$request->input('name'),
					'price'		=>$request->input('price'),
					'deposit'	=>$request->input('deposit'),
					'status'	=>$request->input('status'),
					'product_id'=>$request->input('product_id'),
					'desc'		=>$request->input('desc'),
					'expired'	=>$request->input('expired')
			);
			CardBatch::create($create);
			return array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$errors=$check->messages()->toArray();
			return array('status'=>false,'errors'=>$errors);
		}
		
	}
	/**
	 * 删除是礼品卡批次信息
	 * @param Request $request
	 */
	public function deleteBatch(Request $request){
		$json=array('status'=>false,'error'=>'功能尚未完成！');
		if($request->input('selected') && is_array($request->input('selected'))){
			CardBatch::whereIn('id',$request->input('selected'))->delete();
			$json=array('status'=>true,'success'=>'数据已删除！');
		}else{
			$json=array('status'=>false,'error'=>'请选择要删除的数据！');
		}
		return $json;
	}
	/**
	 * 获取产品信息
	 * @param Request $request
	 */
	public function getProducts(Request $request){
		$products=Products::get();
		return $products;
	}
	/**
	 * 激活对应序列的礼品卡
	 * @param Request $request
	 */
	public function activeCards(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
				'batch_id'		=>'required',
				'from'		=>'required',
				'to'	=>'required'
		]);
		if($check->passes()){
			$count=Cards::where('card_id','>=',$request->input('from'))
				->where('card_id','<=',$request->input('to'))
				->whereNotNull('batch_id')
				->count();
			if ($count) {
				return array('status'=>true,'success'=>'您激活的区间内已经存在被激活的礼品卡，请重新选择区间！');
			}
			Cards::where('card_id','>=',$request->input('from'))
				   ->where('card_id','<=',$request->input('to'))
				   ->whereNull('batch_id')
				   ->update(['batch_id'=>$request->input('batch_id')]);
			return array('status'=>true,'success'=>'礼品卡已激活！');
		}else{
			return array('status'=>false,'error'=>$check->messages()->first());
		}
		
	}
}
?>