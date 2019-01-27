<?php
namespace Readingbar\Back\Controllers\Orders;

use App\Http\Controllers\Controller;
use Readingbar\Back\Controllers\BackController;
use Illuminate\Http\Request;
use DB;
use Readingbar\Api\Frontend\Models\Products;
class BoughtLogController  extends BackController{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'boughtLog.head_title','url'=>'admin/boughtLog','active'=>true),
	);
	public function index(Request $request){
		$data['head_title']=trans('boughtLog.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		if($request->input('keyword')){
			$data['type']=$request->input('type');
			$data['keyword']=$request->input('keyword');
		}else{
			$data['type']='search_type';
			$data['keyword']='';
		}
		$data['products']=Products::get();
		$data['OPmsg']=collect(session('OPmsg')?session('OPmsg'):array())->toJson();
		return $this->view('orders.boughtLog', $data);
	}
	public function getLog(Request $request){
			$data=DB::table('orders as o')
				->crossjoin('students as s','s.id','=','o.owner_id')
				->crossjoin('members as m','m.id','=','s.parent_id')
				->crossjoin('products as p','p.id','=','o.product_id')
				->leftJoin('star_account as sa','sa.asign_to','=','s.id')
				->where(['o.status'=>1])
				->where(function($where) use($request){
						if($request->input('keyword')){
							switch($request->input('type')){
								case 'nick_name':
									$where->where(['s.nick_name'=>$request->input('keyword')]);
									break;
								case 'nickname':
									$where->where(['m.nickname'=>$request->input('keyword')]);
									break;
								case 'email':
									$where->where(['m.email'=>$request->input('keyword')]);
									break;
								case 'cellphone':
									$where->where(['m.cellphone'=>$request->input('keyword')]);
									break;
								case 'star_account':
									$where->where(['sa.star_account'=>'readingbar'.$request->input('keyword')]);
									break;
							}
						}
						if ($request->input('product_id')) {
							$where->where(['p.id'=>$request->input('product_id')]);
						}
				})
				->select(['m.nickname as parent','m.email','m.cellphone','s.nick_name as student','o.*','p.product_name','sa.star_account'])
				->orderBy($this->asignColumn($request->input('order')),$request->input('sort')=='desc'?$request->input('sort'):'asc')
				->paginate($request->input('limit')>0?$request->input('limit'):10);
			foreach ($data as $d){
				$d->refunds=DB::table('orders as o')
										->where(['refund_oid'=>$d->id])
										->groupBy('o.order_type')
										->get([DB::raw('sum(total) as total'),'o.order_type']);
			}
			return $data;
	}
	public function asignColumn($c){
		$order='o.id';
		$table=array(
				'o'=>['completed_at','order_id','id'],
				's'=>['nick_name'],
				'm'=>['nickame','cellphone','email'],
				'p'=>['product_name']
		);
		foreach ($table as $k=>$v){
			if(in_array($c,$v)){
				$order=$k.".".$c;
			}
		}
		return $order;
	}
}