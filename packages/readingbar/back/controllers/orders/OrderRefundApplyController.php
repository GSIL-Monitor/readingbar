<?php
namespace Readingbar\Back\Controllers\Orders;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use DB;
use Readingbar\Back\Models\OrdersRefundApply;
use Readingbar\Back\Models\Members;
use Readingbar\Back\Models\Orders;
use Readingbar\Back\Controllers\Messages\AlidayuSendController;
class OrderRefundApplyController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'refundDepositApply.head_title','url'=>'admin/refundDepositApply','active'=>true),
	);
	/**
	 * 界面+api
	 * @param Request $request
	 */
	public function index(Request $request){
		if($request->ajax()){
			$result = OrdersRefundApply::crossJoin('orders','orders.id','=','orders_refund_apply.order_id')
			->leftJoin('star_account','star_account.asign_to','=','orders.owner_id')
			->where(function($where)use($request){
				if($request->input('trade_no')){
					$where->where(['orders.serial'=>$request->input('trade_no')]);
				}
				if($request->input('order_id')){
					$where->where(['orders.order_id'=>$request->input('order_id')]);
				}
				if(in_array($request->input('status'),[0,1])){
					$where->where(['orders_refund_apply.status'=>$request->input('status')]);
				}
			})
			->orderBy('created_at','desc')
			->select(['orders_refund_apply.*','serial as trade_no','orders.order_id as order_number','star_account','pay_type'])
			->paginate(10);
			foreach ($result as $v) {
				$v->refundDetail = url('admin/orders/'.$v->order_id.'/refundApply');
				$v->refundList = url('admin/orders/'.$v->order_id.'/refundList');
			}
			return $result;
		}else{
			$data['head_title']=trans('orders.head_title');
			$data['breadcrumbs']=$this->breadcrumbs;
			return $this->view('orders.orderRefundApplyList', $data);
		}
	}
	public function complete(Request $request){
		$check = validator($request->all(),[
				'id'=>'required|exists:orders_refund_apply,id,status,0'
		]);
		if ($check->passes()){
			// 根据申请查找订单
			$order = Orders::crossjoin('orders_refund_apply','orders.id','=','orders_refund_apply.order_id')
								->where(['orders_refund_apply.id'=>$request->input('id')])
								->first(['orders.*']);
			
			// 根据退款申请找到会员
			$member = Members::whereIn('id',function($query)use($order){
				$query->select('parent_id')->from('students')
							->crossjoin('orders','orders.owner_id','=','students.id')
							->where(['orders.id'=>$order->id]);
			})->first(['members.*']);
			// 押金退回短信通知
			$alidayu = new AlidayuSendController();
			$alidayu->send('return_deposit',$member->cellphone,[
					'product_id'=>$order->product_id
			]);
			OrdersRefundApply::where(['id'=>$request->input('id')])->update(['status'=>1]);
			$result = OrdersRefundApply::where(['id'=>$request->input('id')])->first();
			return $result;
		}else{
			return response(['message'=>$result],400);
		}
	}
}
?>