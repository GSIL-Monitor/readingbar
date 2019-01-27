<?php

namespace Readingbar\Front\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use Readingbar\Api\Frontend\Models\Orders;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Students;
use WxPay;
use DB;
use Readingbar\Api\Frontend\Controllers\Product\ProductExtraPriceController;
use Readingbar\Api\Frontend\Controllers\Discount\DiscountController;
use Readingbar\Back\Factory\Product\ProductFactory;
class PayController extends FrontController
{
	/*支付确认*/
	public function confirm(Request $request){
		$data['head_title']='支付确认';
		$check=Validator::make($request->all(),[
				'protocol'=>'required|in:true',
				'student_id'=>'required|exists:students,id,parent_id,'.auth('member')->getId(),
				'product_id'=>'required|exists:products,id'
		]);
		if($check->passes()){
			// 产品认购前校验
			$pcheck=ProductFactory::checkBeforeBuy(
					Products::where(['id'=>$request->input('product_id')])->first(),
					Students::where(['id'=>$request->input('student_id')])->first()
			);
			if (!$pcheck->check()) {
				if($request->ajax()){
					return ['status'=>false,'error'=>$pcheck->message()];
				}else{
					return redirect()->back()->with(['alert'=>$pcheck->message()]);
				}
			}
			$data['product']=Products::where(['id'=>$request->input('product_id')])->first()->toArray();
			$student = Students::where(['id'=>$request->input('student_id')])->first();
			$data['student']=$student->toArray();
			// 借阅产品  购买是否免除押金
			if (in_array($data['product']['id'],[14,15]) && $student->hasDepositOfProject($data['product']['id'])) {
				$data['product']['deposit'] = 0;
			}
			//额外费用计算
			$data['product']['price']=$data['product']['price']+ProductExtraPriceController::getExtraPrice($data['product']['id'],$data['student']['province']);
			// 续费优惠
			$data['product']['renew_discount_price']=ProductFactory::renewDiscountPrice(
					Products::where(['id'=>$request->input('product_id')])->first(),
					Students::where(['id'=>$request->input('student_id')])->first()
			);
			$data['action']=url('api/member/order/create');
			return $this->view('pay.confirm', $data);
		}else{
			if($check->errors()->has('product_id')){
				$error="产品不存在！";
			}elseif($check->errors()->has('protocol')){
				$error="请同意购买协议！";
			}elseif($check->errors()->has('student_id')){
				$error="孩子不存在！";
			}else{
				$error="未知错误！";
			}
			return back()->with(['alert'=>$error]);
		}
	}
	/*续费确认*/
	public function renewConfirm(Request $request){
		$data['head_title']='续费确认';
		$check=Validator::make($request->all(),[
				'student_id'=>'required|exists:students,id,parent_id,'.auth('member')->getId(),
				'service_id'=>'required|exists:services,id'
		]);
		if($check->passes()){
			if(!Students::hasService($request->input('student_id'),$request->input('service_id'))){
				return redirect()->back()->with(['alert'=>'亲~您服务已过期，请重新购买产品~']);
			}
			$o=Orders::leftjoin('products','products.id','=','orders.product_id')
					->where(['orders.owner_id'=>$request->input('student_id'),'orders.status'=>1,'products.service_id'=>$request->input('service_id')])
					->orderBy('products.id','desc')
					->first(['product_id']);
			if(!$o){
				return redirect()->back()->with(['alert'=>'亲~您未购买过任何服务，无法为您续费！']);
			}
			$p=Products::where(['id'=>$o->product_id])->first(['buy_again']);
			if(!$p || !$p->buy_again){
				return redirect()->back()->with(['alert'=>'亲~您所购买的服务无续费产品！']);
			}
			if($p->buy_again==8){
				return redirect()->back()->with(['alert'=>'亲～该服务不能续费！']);
			}
			// 产品认购前校验
			$pcheck=ProductFactory::checkBeforeBuy(
					Products::where(['id'=>$p->buy_again])->first(),
					Students::where(['id'=>$request->input('student_id')])->first()
			);
			if (!$pcheck->check()) {
				if($request->ajax()){
					return ['status'=>false,'error'=>$pcheck->message()];
				}else{
					return redirect()->back()->with(['alert'=>$pcheck->message()]);
				}
			}
			$data['product']=Products::where(['id'=>$p->buy_again])->first()->toArray();
			$student = Students::where(['id'=>$request->input('student_id')])->first();
			$data['student']=$student->toArray();
			$data['service_id']=$request->input('service_id');
			
			// 借阅产品  购买是否免除押金
			if (in_array($data['product']['id'],[14,15]) && $student->hasDepositOfProject($data['product']['id'])) {
				$data['product']['deposit'] = 0;
			}
			//额外费用计算
			$data['product']['price']=$data['product']['price']+ProductExtraPriceController::getExtraPrice($data['product']['id'],$data['student']['province']);
			// 续费优惠
			$data['product']['renew_discount_price']=ProductFactory::renewDiscountPrice(
					Products::where(['id'=>$p->buy_again])->first(),
					Students::where(['id'=>$request->input('student_id')])->first()
			);
			$data['action']=url('api/member/order/renew');
			return $this->view('pay.confirm', $data);
		}else{
			if($check->errors()->has('service_id')){
				$error="服务不存在！";
			}elseif($check->errors()->has('student_id')){
				$error="孩子不存在！";
			}else{
				$error="未知错误！";
			}
			return redirect(url('product/list'))->with(['alert'=>$error]);
		}
	}
	//产品校验
	public function checkProduct($p){
		//产品数量校验
		if($p->quantity==0){
			return array('status'=>false,'error'=>'此产品已售完！');
		}
		//会员每月限制购买数
		if($p->buy_limit_in_month>0){
			$count=DB::table('orders as o')
			->leftjoin('students as s','s.id','=','o.owner_id')
			->leftjoin('members as m','m.id','=','s.parent_id')
			->where(['o.status'=>1,'o.product_id'=>$p->id,'m.id'=>auth('member')->getId(),'order_type'=>0])
			->where('o.completed_at','like','%'.date('Y-m',time()).'%')
			->count();
			if($count>=$p->buy_limit_in_month){
				return array('status'=>false,'error'=>'该产品每个用户每月限购'.$p->buy_limit_in_month.'次！');
			}
		}
		return array('status'=>true,'success'=>'产品校验通过！');
	}
}
