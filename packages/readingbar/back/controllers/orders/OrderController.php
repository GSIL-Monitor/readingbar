<?php
namespace Readingbar\Back\Controllers\Orders;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\Orders;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\OrdersRefund;
use Readingbar\Back\Models\Promotions;
use Excel;
use DB;
use Readingbar\Back\Models\Discount;
use Readingbar\Back\Models\KuaidiniaoExpress;
class OrderController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'orders.head_title','url'=>'admin/orders','active'=>true),
	);
	/**
	 * 订单列表
	 */
	public function ordersList(){
		$data['head_title']=trans('orders.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('orders.orderList', $data);
	}
	/**
	 * 退款订单列表
	 */
	public function refundList($id){
		$data['head_title']=trans('orders.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['order_id']=$id;
		return $this->view('orders.refundList', $data);
	}
	/**
	 * 订单表单
	 * @param Integer $id
	 */
	public function orderForm($id=null){
		$data['head_title']=trans('orders.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['order_id']=$id;
		return $this->view('orders.orderForm', $data);
	}
	/**
	 * 退款申请
	 * @param unknown $id
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function refundApply($id){
		$data['head_title']=trans('orders.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$order=Orders::where(['id'=>$id])->first();
		if ($order) {
			$data['order_id']=$id;
			$data['deposit'] = $order->deposit;
			$data['express_cost']=KuaidiniaoExpress::where(['order_id'=>$id])->sum('cost');
			return $this->view('orders.refundApply', $data);
		}
		return redirect()->back();
	}
	/**
	 * 获得所有订单信息
	 * @param Request $request
	 */
	public function getOrders(Request $request){
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
		if($request->input('order') && in_array($request->input('order'),['id','created_at'])){
			if(in_array($request->input('order'),['id','created_at'])){
				$order='orders.'.$request->input('order');
			}
		}else{
			$order='orders.completed_at';
		}
		if($request->input('status') && in_array($request->input('status'),['0','1'])){
			$status=(int)$request->input('status');
		}else{
			$status='1';
		}
		$rs=Orders::leftjoin('students as s','s.id','=','orders.owner_id')
			->leftjoin('members as m','m.id','=','s.parent_id')
			->leftjoin('products as p','p.id','=','orders.product_id')
			->leftjoin('orders as or','or.refund_oid','=','orders.id')
			->where(['orders.status'=>$status])
			//->where('orders.total','>',10)
			->where(['orders.order_type'=>0])
			->where('orders.order_id','like','%'.$request->input('order_id').'%')
			->where('orders.serial','like','%'.$request->input('trade_no').'%')
			->where('m.email','like','%'.$request->input('email').'%')
			->where('m.cellphone','like','%'.$request->input('cellphone').'%');
		if($request->input('product_id')){
			$rs=$rs->where(['orders.product_id'=>$request->input('product_id')]);
		}
		if($request->input('fromDate')){
			$rs=$rs->where('orders.completed_at','>',$request->input('fromDate'));
		}
		if($request->input('toDate')){
			$rs=$rs->where('orders.completed_at','<',date('Y-m-d',strtotime($request->input('toDate'))+60*60*24));
		}
		if($request->input('pcode')){
			$rs=$rs->where('m.pcode','=',$request->input('pcode'));
		}
		$rs=$rs->where('orders.pay_type','like','%'.$request->input('pay_type').'%')
			->orderBy($order,$sort)
			->groupBy('orders.id')
			->selectRaw('orders.id,orders.total,orders.order_id,orders.serial,orders.price,orders.deposit,orders.completed_at,orders.memo,IF(orders.status=1,"已支付","未支付") as status,IF(orders.pay_type="wxpay","微信支付",IF(orders.pay_type="alipay","支付宝","其他")) as pay_type,p.product_name,m.cellphone,m.email,s.name,s.nick_name,s.province,count(or.id) as refund')
			->paginate($limit);
		foreach ($rs as $k=>$v){
			$rs[$k]['edit']=url('admin/orders/'.$v->id.'/form');
			$rs[$k]['refundList']=url('admin/orders/'.$v->id.'/refundList');
			$rs[$k]['refundApply']=url('admin/orders/'.$v->id.'/refundApply');
			$rs[$k]['expressCost']=url('admin/express/order/'.$v->id);
		}
		return $rs;
	}
	/**
	 * 获取订单详情
	 * @param Request $request
	 * @return unknown
	 */
	public function getOrder(Request $request){
		$r=Orders::leftjoin('students as s','s.id','=','orders.owner_id')
			->leftjoin('members as m','m.id','=','s.parent_id')
			->leftjoin('products as p','p.id','=','orders.product_id')
			->leftjoin('orders_refund as or','or.order_id','=','orders.id')
			->where(['orders.id'=>$request->input('order_id')])
			->selectRaw('orders.id,orders.total,orders.order_id,orders.serial,orders.price,orders.deposit,orders.completed_at,orders.memo,IF(orders.status=1,"已支付","未支付") as status,IF(orders.pay_type="wxpay","微信支付",IF(orders.pay_type="alipay","支付宝","其他")) as pay_type,p.product_name,m.cellphone,m.email,s.name,s.nick_name,s.province,count(or.id) as refund')
			->first();
		$r['refundApply']=url('admin/orders/'.$r['id'].'/refundApply');
		return $r;
	}
	/**
	 * 获取退款订单列表
	 * @param Request $request
	 */
	public function getRefunds(Request $request){
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
		if($request->input('order') && in_array($request->input('order'),['id','created_at'])){
			if(in_array($request->input('order'),['id','created_at'])){
				$order='orders.'.$request->input('order');
			}
		}else{
			$order='orders.id';
		}
		if($request->input('status') && in_array($request->input('status'),['0','1'])){
			$status=(int)$request->input('status');
		}else{
			$status='1';
		}
		$rs=Orders::where(['refund_oid'=>$request->input('order_id')])->paginate($limit);
		return $rs;
	}
	/**
	 * 创建退款订单
	 */
	public function createRefund(Request $request){
		$inputs=$request->all();
		$check=Validator::make(
			$inputs,[
				'id'=>'required|exists:orders,id',
				'refund_no'=>'required',
				'refund_total'=>'required',
				'memo'=>'required',
				'order_type'=>'required|in:1,2,3'
			]
		);
		if($check->passes()){
			switch ($request->input('order_type')) {
				case '3': return $this->createRefund2($request);
				default: return $this->createRefund1($request);
			}
		}else{
			return response(['data'=>$check->errors(),'message'=>'数据校验错误！','success'=>false],400);
		}
	}
	// 退押金，退款并订单作废
	private function createRefund1($request) {
		$refund=array(
				'refund_oid'=>$request->input('id'),
				'serial'=>$request->input('refund_no'),
				'total'=>$request->input('refund_total')>0?-$request->input('refund_total'):$request->input('refund_total'),
				'memo'=>$request->input('memo'),
				'order_type'=>$request->input('order_type'),
				'status'=>1,
		);
		//var_dump($refund);exit;
		if(Orders::create($refund)){
			$order=Orders::where(['id'=>$request->input('id')])->first();
			DB::select('call updateStudentServices('.$order->owner_id.')');
			if($request->input('order_type')==2){
				Discount::changeDiscountStatusByOerateTag('orders_'.$request->input('id'),3);
			}
		}
		$message = $request->input('order_type')==1?'退款订单已生成！':'退款订单已生成并且该订单作废！';
		return ['message'=>$message,'success'=>true];
	}
	// 定制服务退部分款项 转 综合服务
	private function createRefund2($request) {
		$order=Orders::where(['id'=>$request->input('id')])->first();
		if ($order->product_id == 1) {
			if (Orders::where(['refund_oid'=>$request->input('id'),'order_type'=>2])->count()) {
				return response(['message'=>'该订单已经作废，无法转换服务！','success'=>false],400);
			}else{
				$refund=array(
						'refund_oid'=>$request->input('id'),
						'serial'=>$request->input('refund_no'),
						'total'=>$request->input('refund_total')>0?-$request->input('refund_total'):$request->input('refund_total'),
						'memo'=>$request->input('memo'),
						'order_type'=>2,
						'status'=>1,
				);
				//var_dump($refund);exit;
				if(Orders::create($refund)){
					$newOid = date('YmdHis').round(100000,999999);
					$product = Products::where(['id'=>18])->first();
					Orders::create([
							'order_id'=>$newOid,
							'serial'=>$newOid,
							'owner_id'=>$order->owner_id,
							'product_id'=>$product->id,
							'days'=>$product->days,
							'total'=>$product->price,
							'price'=>$product->price,
							'deposit'=>0,
							'extra_price'=>0,
							'completed_at'=>DB::raw('Now()'),
							'memo'=>'【定制服务】退部分款项转【综合服务】',
							'pay_type'=>'admin',
							'status'=>1
					]);
					DB::select('call updateStudentServices('.$order->owner_id.')');
					Discount::changeDiscountStatusByOerateTag('orders_'.$request->input('id'),3);
				}
				return ['message'=>'服务转换成功!','success'=>true];
			}
		}else{
			return response(['message'=>'转服务操作只适用于【定制服务】','success'=>false],400);
		}
	}
	/**
	 * 获取产品
	 */
	public function getProducts(){
		 return Products::get(['id','product_name']);
	}
	/**
	 * 获取推广员信息
	 */
	public function getPromoters(){
		$rs=Promotions::leftjoin('members as m','m.id','=','promotions.member_id')
			->get(['promotions.pcode','m.nickname']);
		return $rs;
	}
	/**
	 * 导出订单
	 */
	public function exportOrders(Request $request){
		$rs=Orders::leftjoin('students as s','s.id','=','orders.owner_id')
			->leftjoin('members as m','m.id','=','s.parent_id')
			->leftjoin('products as p','p.id','=','orders.product_id')
			->leftjoin('orders as or','or.refund_oid','=','orders.id')
			->leftjoin('promotions','promotions.pcode','=','m.pcode')
			->leftjoin('members as promoter','promoter.id','=','promotions.member_id')
			->where(['orders.order_type'=>0])
			->where(['orders.status'=>1])
			->where('orders.total','>',10)
			->where('orders.order_id','like','%'.$request->input('order_id').'%')
			->where('orders.serial','like','%'.$request->input('trade_no').'%')
			->where('m.email','like','%'.$request->input('email').'%')
			->where('m.cellphone','like','%'.$request->input('cellphone').'%');
		if($request->input('product_id')){
			$rs=$rs->where(['orders.product_id'=>$request->input('product_id')]);
		}
		if($request->input('fromDate')){
			$rs=$rs->where('orders.completed_at','>',$request->input('fromDate'));
		}
		if($request->input('toDate')){
			$rs=$rs->where('orders.completed_at','<',date('Y-m-d',strtotime($request->input('toDate'))+60*60*24));
		}
		if($request->input('pcode')){
			$rs=$rs->where('m.pcode','=',$request->input('pcode'));
		}
		$exportColums=array(
				'orders.id',
				'orders.order_id',
				'orders.serial',
				'm.nickname as parent',
				's.name as student_name',
				's.nick_name as student_nickname',
				'm.email',
				'm.cellphone',
				"concat_ws('',s.province,s.city,s.area) as address",
				'promoter.nickname as promoter',
				'p.product_name',
				'orders.price',
				'orders.deposit',
				'orders.extra_price',
				'orders.total',
				'orders.completed_at',
				'orders.memo',
				'IF(count(or.id),"已退款",IF(orders.deposit>0,"未退款","")) as refund_status',
				'sum(or.total) as refund_total',
				'IF(orders.pay_type="wxpay","微信支付",IF(orders.pay_type="alipay","支付宝","其他")) as pay_type'
		);
		$rs=$rs->where('orders.pay_type','like','%'.$request->input('pay_type').'%')
			->groupBy('orders.id')
			->selectRaw(implode(',',$exportColums))
			->get()
			->toArray();
		$title=array('订单编号','订单号','交易号','家长','孩子','孩子昵称','邮箱','手机','地址','推广员','产品','产品价格','产品押金','产品额外价格','订单支付金额','支付日期','订单备注','退款状态','退款金额','支付类型');
		$export=collect($rs)->prepend($title);
		ob_end_clean();
		Excel::create('订单信息'.date('Y-m-d',time()),function($excel) use ($export){
			$excel->sheet('score', function($sheet) use ($export){
				$sheet->rows($export);
			});
		})->store('xls')->export('xls');
	}
}
?>