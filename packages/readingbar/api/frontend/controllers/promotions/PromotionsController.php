<?php

namespace Readingbar\Api\Frontend\Controllers\Promotions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Api\Frontend\Controllers\FrontController;
use App\Http\Requests;
use Readingbar\Api\Frontend\Models\Members;
use Readingbar\Api\Frontend\Models\Products;
use Readingbar\Api\Frontend\Models\Students;
use Readingbar\Api\Frontend\Models\Orders;
use DB;
use QrCode;
class PromotionsController extends FrontController
{
	private $promoter=null;
	public function __construct(){
		$this->promoter=Members::leftjoin('promotions','promotions.member_id','=','members.id')
				->leftjoin('promotions_type','promotions_type.id','=','promotions.type')
				->whereNotNull('promotions.pcode')
				->where(['promotions.member_id'=>auth('member')->getId()])
				->first(['promotions.*','promotions_type.products']);
	}
	/*推广查询-会员信息*/
	public function getMembers(Request $request){
		if(!$this->promoter){
			return array('status'=>false,'error'=>'对不起，您不是推广员！');
			return;
		}
		if($request->input('limit') && $request->input('limit')>1){
			$limit=$request->input('limit');
		}else{
			$limit=10;
		}
		if($request->input('order') && in_array($request->input('sort'),['id','created_at'])){
			$order=$request->input('order');
		}else{
			$order='id';
		}
		if($request->input('sort') && in_array($request->input('sort'),['asc','desc'])){
			$sort=$request->input('sort');
		}else{
			$sort='asc';
		}
		if($request->input('star') && strtotime($request->input('star'))){
			$star=$request->input('star');
		}
		if($request->input('end') && strtotime($request->input('end'))){
			$end=date('Y-m-d',strtotime($request->input('end'))+60*60*24);
		}
		$members=Members::leftjoin('students','students.parent_id','=','members.id')
		->where(['members.pcode'=>$this->promoter->pcode])
		->orderBy('members.id')
		->groupBy('members.id')
		->select(DB::raw('members.id,members.nickname,members.created_at,count(students.id) as children'));
		if(isset($star) && isset($end)){
			$members=$members->whereBetween('members.created_at',[$star,$end]);
		}
		$members=$members->paginate($limit);
		foreach ($members as $key=>$value){
			$members[$key]['products']=Orders::crossjoin('students','orders.owner_id','=','students.id')
															->crossjoin('members','students.parent_id','=','members.id')
															->crossjoin('products','products.id','=','orders.product_id')
															->where(['members.id'=>$value->id,'orders.status'=>1])
															->groupBy('products.id')
															->select(['products.product_name',DB::raw('count(products.id) as quantity')])
															->get();
		}
		$members=$members->toArray();
		$this->json=$members;
		$this->json['status']=true;
		$this->echoJson();
	}
	/*推广查询订单状态*/
	public function getMOrders(Request $request){
		if(!$this->promoter){
			$this->json=array('status'=>false,'error'=>'对不起，您不是推广员！');
			$this->echoJson();
			return;
		}
		if($request->input('limit') && $request->input('limit')>1){
			$limit=$request->input('limit');
		}else{
			$limit=10;
		}
		if($request->input('order') && in_array($request->input('sort'),['id','created_at'])){
			$order=$request->input('order');
		}else{
			$order='id';
		}
		if($request->input('sort') && in_array($request->input('sort'),['asc','desc'])){
			$sort=$request->input('sort');
		}else{
			$sort='asc';
		}
		if($request->input('status') && in_array($request->input('status'),[1,2])){
			$status=$request->input('status');
		}else{
			$status=0;
		}
		if($request->input('star') && strtotime($request->input('star'))){
			$star=$request->input('star');
		}
		if($request->input('end') && strtotime($request->input('end'))){
			$end=date('Y-m-d',strtotime($request->input('end'))+60*60*24);
		}
		$orders=Orders::leftjoin('students','students.id','=','orders.owner_id')
				->leftjoin('members','students.parent_id','=','members.id')
				->leftjoin('products','products.id','=','orders.product_id')
				->where(['members.pcode'=>$this->promoter->pcode])
			    ->orderBy('orders.id','desc');
		if($status){
			if($status==1){
				$orders=$orders->where(['status'=>1]);
			}else{
				$orders=$orders->where(['status'=>0]);
			}
		}
		$orders=$orders->whereIn('orders.product_id',unserialize($this->promoter->products));
		if(isset($star) && isset($end)){
			$orders=$orders->whereBetween('orders.created_at',[$star,$end]);
		}
		//$sql=$orders->select(['orders.*','members.nickname as parent','students.name as child','product_name','students.province as area'])->toSql();
		$orders=$orders->select(['orders.*','members.nickname as parent','students.name as child','product_name','students.province as area'])
			->paginate($limit)
			->toArray();
		foreach ($orders['data'] as $key=>$o) {
			if ($o['status'] == 1) {
				$r=Orders::where('id','<',$o['id'])->where(
						[
								'owner_id' => $o['owner_id'],
								'product_id' =>   $o['product_id'],
								'status' => 1
						]
						)->first();
						if ($r) {
							$orders['data'][$key]['product_name'] = '续费+'.$o['product_name'];
						}
			}
		}
		$this->json=$orders;
		//$this->json['sql']=$sql;
		$this->json['status']=true;
		$this->echoJson();
	}
	/*推广查询面板*/
	public function getDashboard(){
		if(!$this->promoter){
			$this->json=array('status'=>false,'error'=>'对不起，您不是推广员！');
			$this->echoJson();
			return;
		}
		switch($this->promoter->view){
			case '1':
				//自主会员相关查询
				$this->json['total_members']=Members::where(['members.pcode'=>$this->promoter->pcode])->count();
				$this->json['total_hc_members']=Students::leftjoin('members','members.id','=','students.parent_id')
												->where(['members.pcode'=>$this->promoter->pcode])
												->distinct()
												->count(['members.id']);
				$this->json['total_hnc_members']=$this->json['total_members']-$this->json['total_hc_members'];
		
				$this->json['total_pay']=Orders::leftjoin('students','orders.owner_id','=','students.id')
											  ->leftjoin('members','members.id','=','students.parent_id')
											  ->where(['members.pcode'=>$this->promoter->pcode,'orders.status'=>1,'orders.product_id'=>3])
											  ->where('orders.total','>','1')
											  ->sum('orders.total');
				$this->json['total_orders']=Orders::leftjoin('students','orders.owner_id','=','students.id')
											  ->leftjoin('members','members.id','=','students.parent_id')
											  ->where(['members.pcode'=>$this->promoter->pcode,'orders.product_id'=>3])
											  ->count();
				$this->json['total_hp_orders']=Orders::leftjoin('students','orders.owner_id','=','students.id')
											  ->leftjoin('members','members.id','=','students.parent_id')
											  ->where(['members.pcode'=>$this->promoter->pcode,'orders.status'=>1,'orders.product_id'=>3])
											  ->count();
				$this->json['total_hnp_orders']=$this->json['total_orders']-$this->json['total_hp_orders'];
				break;
				case '2':
					//定制会员相关查询
					$this->json['total_members']=Members::where(['members.pcode'=>$this->promoter->pcode])->count();
					$this->json['total_hc_members']=Students::leftjoin('members','members.id','=','students.parent_id')
													->where(['members.pcode'=>$this->promoter->pcode])
													->distinct()
													->count(['members.id']);
					$this->json['total_hnc_members']=$this->json['total_members']-$this->json['total_hc_members'];
			
					$this->json['total_pay']=Orders::leftjoin('students','orders.owner_id','=','students.id')
												  ->leftjoin('members','members.id','=','students.parent_id')
												  ->where(['members.pcode'=>$this->promoter->pcode,'orders.status'=>1,'orders.product_id'=>1])
												  ->where('orders.total','>','1')
												  ->sum('orders.total');
					$this->json['total_orders']=Orders::leftjoin('students','orders.owner_id','=','students.id')
												  ->leftjoin('members','members.id','=','students.parent_id')
												  ->where(['members.pcode'=>$this->promoter->pcode,'orders.product_id'=>1])
												  ->count();
					$this->json['total_hp_orders']=Orders::leftjoin('students','orders.owner_id','=','students.id')
												  ->leftjoin('members','members.id','=','students.parent_id')
												  ->where(['members.pcode'=>$this->promoter->pcode,'orders.status'=>1,'orders.product_id'=>1])
												  ->count();
					$this->json['total_hnp_orders']=$this->json['total_orders']-$this->json['total_hp_orders'];
					break;
			case '3':
					$this->json['total_members']=Members::where(['members.pcode'=>$this->promoter->pcode])->count();
					$this->json['total_hc_members']=Students::leftjoin('members','members.id','=','students.parent_id')
						->where(['members.pcode'=>$this->promoter->pcode])
						->distinct()
						->count(['members.id']);
					$this->json['total_hnc_members']=$this->json['total_members']-$this->json['total_hc_members'];
				break;
			default:
				$this->json['total_members']=Members::where(['members.pcode'=>$this->promoter->pcode])->count();
				$this->json['total_hc_members']=Students::leftjoin('members','members.id','=','students.parent_id')
												->where(['members.pcode'=>$this->promoter->pcode])
												->distinct()
												->count(['members.id']);
				$this->json['total_hnc_members']=$this->json['total_members']-$this->json['total_hc_members'];
		
				$this->json['total_pay']=Orders::leftjoin('students','orders.owner_id','=','students.id')
											  ->leftjoin('members','members.id','=','students.parent_id')
											  ->where(['members.pcode'=>$this->promoter->pcode,'orders.status'=>1])
											  ->where('orders.total','>','1')
											  ->sum('orders.total');
				$this->json['total_orders']=Orders::leftjoin('students','orders.owner_id','=','students.id')
											  ->leftjoin('members','members.id','=','students.parent_id')
											  ->where(['members.pcode'=>$this->promoter->pcode])
											  ->count();
				$this->json['total_hp_orders']=Orders::leftjoin('students','orders.owner_id','=','students.id')
											  ->leftjoin('members','members.id','=','students.parent_id')
											  ->where(['members.pcode'=>$this->promoter->pcode,'orders.status'=>1])
											  ->count();
				$this->json['total_hnp_orders']=$this->json['total_orders']-$this->json['total_hp_orders'];
				
				
		}
		$this->json['promote_url']=url('register?pcode='.$this->promoter->pcode);
		
		if(!file_exists(public_path('files/qrcodes'))) mkdir(public_path('files/qrcodes'));
		$dir='files/qrcodes/qrcode_'.$this->promoter->pcode.'.png';
		if(!file_exists(public_path($dir))){
			QrCode::format('png')->size(100)->generate($this->json['promote_url'],public_path($dir));
		}
		$this->json['promote_qrcode']=url($dir);
		$this->json['status']=true;
		$this->echoJson();
	}
	/*推广查询-数据导出*/
	public function exportPromotionsInfo(){
		if(!$this->promoter){
			$this->json=array('status'=>false,'error'=>'对不起，您不是推广员！');
			$this->echoJson();
			return;
		}
	}
}
