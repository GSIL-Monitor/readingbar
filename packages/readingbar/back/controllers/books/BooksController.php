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
use Readingbar\Back\Models\Cards;
use Validator;
class BooksController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'cards.head_title','url'=>'admin/gift/cards','active'=>true),
	);
	/**
	 * 礼品卡列表
	 */
	public function cardsList(){
		$data['head_title']=trans('cards.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('gift.cardsList', $data);
	}
	/**
	 * 获所有卡的数据
	 * @param Request $request
	 */
	public function getCardsList(Request $request){
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
		$cards=Cards::leftjoin('card_batch','card_batch.id','=','cards.batch_id')
					->leftjoin('products','products.id','=','card_batch.product_id')
					->whereNotNull('cards.batch_id')
					->whereNotNull('cards.student_id')
					->selectRaw('cards.*,card_batch.name as batch_name,products.product_name,IF(cards.sent=1,"已发放","未发放") as sent')
					->paginate($limit);
		return $cards;
	}
	/**
	 * 设置礼品发放状态-备注信息
	 * @param Request $request
	 */
	public function setSent(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
				'card_id'		=>'required|exists:cards,card_id',
				'memo'			=>'',
		]);
		if($check->passes()){
			$update=array(
				'card_id'=>$request->input('card_id'),
				'memo'=>$request->input('memo'),
				'sent'=>1
			);
			Cards::where(['card_id'=>$request->input('card_id')])->update($update);
			return array('status'=>true,'success'=>'礼品已发放！');
		}else{
			return array('status'=>false,'error'=>$check->messages()->first());
		}
	}
}
?>