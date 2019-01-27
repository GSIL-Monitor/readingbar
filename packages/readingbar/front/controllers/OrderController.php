<?php

namespace Readingbar\Front\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Readingbar\Back\Models\Orders;
use Readingbar\Back\Models\OrdersRefundApply;
use Readingbar\Back\Controllers\Messages\AlidayuSendController;
use Readingbar\Back\Models\ReadPlan;
use Readingbar\Back\Models\Students;

class OrderController extends FrontController
{
	/*关于我们*/
	public function index(){
		$data['head_title']='我的订单';
		return $this->view('order.orders', $data);
	}
	/*退押金申请*/
	public function applyRefundDeposit(Request $request){
		$check = validator($request->all(),[
				'id'=>'required|exists:orders,id'
		]);
		if ($check->passes()){
			// 获取借阅订单
			$order = Orders::where(['id'=>$request->input('id')])
							->whereIn('owner_id',function($query){
								return $query->select('id')->from('students')->where('parent_id','=',auth('member')->user()->id);
							})
							->whereIn('product_id',[14,15])
							->first();
			if ($order) {
				// 判断该订单的孩子是否有未完成的借阅计划
				$student = Students::where(['id'=>$order->owner_id])->first();
				if ($student->uncompletedBorrowService()) {
					return response(['message'=>'您好，请在收到还书验收成功短信后申请退押金，谢谢！'],400);
				}
				// 是否已申请过退押金
				$apply = OrdersRefundApply::where(['order_id'=>$request->input('id')])->first();
				if (!$apply) {
					OrdersRefundApply::create([
							'order_id'=>$order->id
					]);
					// 退押金申请短信通知
					$alidayu = new AlidayuSendController();
					$alidayu->send('apply_return_deposit',auth('member')->user()->cellphone,[
							'product_id'=>$order->product_id
					]);
					return response(['message'=>'您已申请成功！']);
				}else{
					switch ($apply->status){
						case 0: return response(['message'=>'退押金申请已提交成功，我们将在5个工作日内原路退还押金，请注意查收！'],400);
						case 1: return response(['message'=>'该订单的退押金申请已被处理！'],400);
					}
				}
			}
		}
		return response(['message'=>'找不到对应订单！'],400);
	}
}
