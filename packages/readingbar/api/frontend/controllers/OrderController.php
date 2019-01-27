<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Validator;
use Readingbar\Back\Models\Orders;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Members;
use Readingbar\Api\Frontend\Models\StarAccountAsign;
use Readingbar\Api\Frontend\Models\StarAccount;
use Messages;
use Superadmin\Backend\Models\User;
use Readingbar\Back\Models\TimedTask;
use WxPay;
use Packages\Pay\Wxpay\Sdk\WxPayConfig;
use Log;
use Readingbar\Api\Frontend\Models\PayNotifyLog;
use Readingbar\Api\Frontend\Controllers\Product\ProductExtraPriceController;
use Readingbar\Api\Frontend\Controllers\Discount\DiscountController;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Readingbar\Back\Models\Discount;
use Readingbar\Back\Models\ServiceStatus;
use Readingbar\Back\Models\Promotions;
use Readingbar\Back\Controllers\Spoint\PointController;
use Readingbar\Back\Models\ReadPlan;
use Readingbar\Back\Factory\Product\ProductFactory;
use Readingbar\Back\Models\OrdersRefundApply;
use Readingbar\Back\Controllers\Messages\AlidayuSendController;
use Readingbar\Back\Models\AlidayuMessageSetting;
class OrderController extends FrontController
{
	private $expiratedDays=1;
	/*获取订单*/
	public function getOrders(Request $request){
		if($request->input('page') && $request->input('page')>1){
			$page=(int)$request->input('page');
		}else{
			$page=1;
		}
		if($request->input('limit') && $request->input('limit')>=1){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		if(in_array($request->input('status'),[0,1])){
			$status=(int)$request->input('status');
		}
		
		if(isset($status)){
			if($status==0){
				$dids=Discount::where(['member_id'=>auth('member')->getId()])
					->where('expiration_time','>=',DB::raw('NOW()'))
					->where('order_id','>','0')
 					->get(['order_id'])
 					->pluck('order_id')
 					->all();
				$orders=Students::leftjoin('orders','orders.owner_id','=','students.id')
					->leftjoin('products','orders.product_id','=','products.id')
					->leftjoin('discount as dt','dt.order_id','=','orders.id')
					->where(['students.parent_id'=>auth('member')->getId(),'member_del'=>0])
					->where(['orders.status'=>$status])
					->where(DB::raw('DATE_ADD(orders.created_at,INTERVAL '.$this->expiratedDays.' DAY)'),'>=',DB::raw('NOW()'))
					->orWhere(function ($query) use ($dids) {
						$query->WhereIn('orders.id',$dids);
					});
			}else{
				$orders=Students::leftjoin('orders','orders.owner_id','=','students.id')
					->leftjoin('products','orders.product_id','=','products.id')
					->leftjoin('discount as dt','dt.order_id','=','orders.id')
					->where(['students.parent_id'=>auth('member')->getId()])
					->where(['orders.status'=>$status]);
			}
		}else{
			$orders=Students::leftjoin('orders','orders.owner_id','=','students.id')
				->leftjoin('products','orders.product_id','=','products.id')
				->where(['students.parent_id'=>auth('member')->getId()]);
		}
		$orders=$orders->groupBy('orders.id');
		//$total =$orders->count();
		//$orders=$orders->skip(($page-1)*$limit)->take($limit)->orderBy('orders.order_id','desc');;
		$orders=$orders->orderBy('orders.order_id','desc')
				->select(['orders.*','students.name as student_name','students.province','products.product_name',DB::raw('sum(dt.price) as discount_price')])
				->paginate($limit);
		
		foreach ($orders as $k=>$v){
			//额外费用计算
			$extra_price=ProductExtraPriceController::getExtraPrice($v['product_id'],$v['province']);
			//额外费用计算
			$orders[$k]['price']=$v['price']+$extra_price;
			$orders[$k]['applyRefundDeposit'] = OrdersRefundApply::where(['order_id'=>$v->id])->first();
		}
		//echo $total."|".$limit;exit;
		return $orders;
	}
	/*支付未付款订单*/
	public function payOrder(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
			'order_id'=>"required|exists:orders,order_id,status,0",
			'pay_type'	=>"required|in:alipay,paypal,wxpay"
		]);
		if($check->passes()){
			//判断订单与会员所属关系
			$student=Orders::leftjoin('students','students.id','=','orders.owner_id')
				->where(['orders.order_id'=>$inputs['order_id'],'students.parent_id'=>auth('member')->getId()])
				->get(['students.*'])
				->first();
			if($student){
					$order=Orders::leftjoin('products','products.id','=','orders.product_id')
						->where(['orders.order_id'=>$inputs['order_id'],'member_del'=>0])
						->first(['orders.*','products.product_name',DB::raw('DATE_ADD(orders.created_at,INTERVAL '.$this->expiratedDays.' DAY) < NOW() as overdue')]);
					
					//产品校验
					$p=Orders::leftjoin('products','products.id','=','orders.product_id')
						->where(['orders.order_id'=>$inputs['order_id'],'member_del'=>0])
						->first(['products.*']);
					$checkProduct=$this->checkProduct($p);
					if($checkProduct['status']===false){
						if($request->ajax()){
							return $checkProduct;
						}else{
							return redirect()->back()->with(['alert'=>$checkProduct['error']]);
						}
					}
					
					if(!$order){
						$error='该订单不存在！';
					}else if($order['overdue']){
						$error='该订单已失效，请重新购买商品！';
					}else{
						return $this->pay($inputs, $order,$request);
					}
			}else{
				$error='您无权操作该订单！';
			}
		}else{
			if($check->errors()->has('pay_type')){
				$error="支付方式不存在！";
			}else{
				$error='订单不存在！';
			}
		}
		if($request->ajax()){
			if($error){
				$this->json=array('status'=>false,'error'=>$error);
			}else{
				$this->json=array('status'=>true);
			}
			$this->echoJson();
		}else{
			return redirect()->back()->with(['alert'=>$error]);
		}
	}
	/*删除未付款订单*/
	public function deleteOrder(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
				'order_id'=>"required|exists:orders,order_id,status,0"
		]);
		if($check->passes()){
			//判断订单与会员所属关系
			$r=Orders::leftjoin('students','students.id','=','orders.owner_id')
				->where(['orders.order_id'=>$inputs['order_id'],'students.parent_id'=>auth('member')->getId()])
				->count();
			if($r){
				//回收相关的优惠券
				$oid=Orders::where(['orders.order_id'=>$inputs['order_id']])->first()['id'];
				DiscountController::returnDiscount($oid);
				
				Orders::where(['orders.order_id'=>$inputs['order_id']])->update(['member_del'=>1]);
				$this->json=array('status'=>true,'success'=>'订单删除成功！');
			}else{
				$this->json=array('status'=>false,'error'=>'您无权操作该订单！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'订单不存在！');
		}
		$this->echoJson();
	}
	/*创建订单-根据选择的产品id*/
	public function createOrder(Request $request){
		
		
		$inputs=$request->all();
		$check=Validator::make($inputs,[
			'product_id'=>"required|exists:products,id",
			'student_id'=>"required|exists:students,id,parent_id,".auth('member')->getId(),
			'pay_type'	=>"required|in:alipay,paypal,wxpay"
		]);
		if($check->passes()){
		    // 产品认购前校验
		    $p=Products::where(['id'=>$request->input('product_id')])->first();
		    $s=Students::where(['id'=>$request->input('student_id')])->first();
			$pcheck=ProductFactory::checkBeforeBuy($p,$s);
			if (!$pcheck->check()) {
				if($request->ajax()){
					return ['status'=>false,'error'=>$pcheck->message()];
				}else{
					return redirect()->back()->with(['alert'=>$pcheck->message()]);
				}
			}
			if($p->service_area=='全国' || in_array($s->province,explode(',',$p->service_area))){
				//额外费用计算
				$extra_price=ProductExtraPriceController::getExtraPrice($p['id'],$s->province);
				//获取折扣价格
				$discountPrice=DiscountController::getDiscountPrice(auth('member')->getId(),$request->input('discounts'),$request->input('product_id'));
				$p['price']=$p['price']-$discountPrice>0?$p['price']-$discountPrice:0;
				// 续费优惠
				$renewDiscountPrice=ProductFactory::renewDiscountPrice(
						Products::where(['id'=>$request->input('product_id')])->first(),
						Students::where(['id'=>$request->input('student_id')])->first()
				);
				$p['price']=$p['price']-$renewDiscountPrice>0?$p['price']-$renewDiscountPrice:0;
				// 借阅产品  购买是否免除押金
				if (in_array($p['id'],[14,15]) && $s->hasDepositOfProject($p['id'])) {
					$p['deposit'] = 0;
				}
				$order=array(
						'product_id'=>$inputs['product_id'],
						'owner_id'		=>$inputs['student_id'],
						'order_id'		=>date('YmdHis').rand(10000,99999),
						'total'   		=>$p['price']+$p['deposit']+$extra_price,
						'price'   		=>$p['price'],
						'deposit'   	=>$p['deposit'],
						'extra_price'   =>$extra_price,
						'days'			=>$p['days'],
						'status'  		=>'0'
				);
				$order=Orders::create($order);
				
				//修改使用的折扣券的状态
				$discountPrice=DiscountController::useDiscounts(auth('member')->getId(),$order['id'],$request->input('discounts'),$request->input('product_id'));
				
				$order['product_name']=$p->product_name;
				if($order['total']<=0){
					$inputs['pay_type']='free';
				}
				return $this->pay($inputs,$order,$request);
			}
			return back()->with(['alert'=>'该学生不在服务区域内！']);
			
		}else{
			if($check->errors()->has('product_id')){
				$error="产品不存在！";
			}elseif($check->errors()->has('pay_type')){
				$error="支付方式不存在！";
			}else{
				$error="学生不存在！";
			}
			//回跳-错误信息
			return back()->with(['alert'=>$error]);
		}
	}
	/*续费*/
	public function renew(Request $request){
		
		$inputs=$request->all();
		$check=Validator::make($inputs,[
				'student_id'=>"required|exists:students,id,parent_id,".auth('member')->getId(),
				'pay_type'	=>"required|in:alipay,paypal,wxpay",
				'service_id'=>"required|exists:services,id"
		]);
		if($check->passes()){
			//校验学生是否可以续费
			
			if(Students::hasService($inputs['student_id'])){
				$s=Students::where(['id'=>$inputs['student_id']])->first();
				//获取用户当前正在使用的产品id
				$cp=Orders::leftjoin('products','products.id','=','orders.product_id')
					->where(['orders.owner_id'=>$inputs['student_id'],'status'=>1,'products.service_id'=>$inputs['service_id']])
					->orderBy('products.id','desc')
					->first(['products.*']);
				$p=Products::where(['id'=>$cp->buy_again])->first();
				if(!$p){
					if($request->ajax()){
						return array('status'=>false,'error'=>'该产品不可续费！');
					}else{
						return redirect()->back()->with(['alert'=>'该产品不可续费！']);
					}
				}
				// 产品认购前校验
				$pcheck=ProductFactory::checkBeforeBuy($p,$s);
				if (!$pcheck->check()) {
					if($request->ajax()){
						return ['status'=>false,'error'=>$pcheck->message()];
					}else{
						return redirect()->back()->with(['alert'=>$pcheck->message()]);
					}
				}
				//额外费用计算
				$extra_price=ProductExtraPriceController::getExtraPrice($cp['id'],$s->province);
				//获取折扣价格
				$discountPrice=DiscountController::getDiscountPrice(auth('member')->getId(),$request->input('discounts'),$cp->buy_again);
				$p->price=$p->price-$discountPrice>0?$p->price-$discountPrice:0;
				// 续费优惠
				$renewDiscountPrice=ProductFactory::renewDiscountPrice(
						Products::where(['id'=>$cp->buy_again])->first(),
						Students::where(['id'=>$request->input('student_id')])->first()
						);
				$p->price=$p->price-$renewDiscountPrice>0?$p->price-$renewDiscountPrice:0;
				
				// 借阅产品  购买是否免除押金
				if (in_array($p['id'],[14,15]) && $s->hasDepositOfProject($p['id'])) {
					$p['deposit'] = 0;
				}
				$order=array(
					'product_id'=>$p->id,
					'owner_id'=>$inputs['student_id'],
					'order_id'=>date('YmdHis').rand(10000,99999),
					'total'=>$p->price+$extra_price+$p->deposit,
					'price'   		=>$p->price,
					'deposit'   	=>$p->deposit,
					'extra_price'   =>$extra_price,
					'days'   		=>$p->days,
					'status'  =>'0'
				);
				$order=Orders::create($order);
				//修改使用的折扣券的状态
				$discountPrice=DiscountController::useDiscounts(auth('member')->getId(),$order['id'],$request->input('discounts'),$cp->buy_again);
				
				$order['product_name']=$p->product_name;
				$inputs['product_id']=$p->id;
				if($order['total']<=0){
					$inputs['pay_type']='free';
				}
				return $this->pay($inputs,$order,$request);
			}else{
				return back();
			}
		}else{
			if($check->errors()->has('pay_type')){
				$error="支付方式不存在！";
			}if($check->errors()->has('service_id')){
				$error="服务不存在！";
			}else{
				$error="学生不存在！";
			}exit;
			//回跳-错误信息
			return back()->with(['alert'=>$error]);
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
	/*支付*/
	function pay($inputs,$order,$request){
		switch($inputs['pay_type']){
			case 'alipay':return $this->alipay($order);break;
			case 'wxpay':return $this->wxpay($order);break;
			case 'free':return $this->free($order,$request);break;
		}
	}
	/*免费支付*/
	function free($order,$request){
		$this->PayNotifyLog($order['order_id'],'alipay',1,$request);
		$this->payCompletedAction($order['order_id'],$order['order_id'],"TRADE_FINISHED","free");

		if($request->ajax()){
			return array('status'=>true,'success'=>'支付完成','redirect'=>url('member/accountCenter/orders'));
		}else{
			return redirect('member/accountCenter/orders')->with(['buy_success'=>'支付完成！','product_id'=>$order->product_id]);
		}
	}
	/*支付宝支付*/
	function alipay($order){
		// 创建支付单。
		$alipay = app('alipay.web');
		$alipay->setOutTradeNo($order['order_id']);
		$alipay->setTotalFee($order['total']);
		$alipay->setSubject($order['product_name']);
		$alipay->setQrPayMode('5'); //该设置为可选，添加该参数设置，支持二维码支付。
		// 跳转到支付页面。
		return redirect()->to($alipay->getPayLink());
	}
	/**
	 * 异步通知
	 */
	public function alipayNotifyUrl(Request $request)
	{
		// 验证请求。
		if (! app('alipay.web')->verify()) {
			return redirect('member/accountCenter/orders')->with(['alert'=>'回调失败！']);
		}
	
		// 判断通知类型。
		switch ($request->input('trade_status')) {
			case 'TRADE_SUCCESS':
			case 'TRADE_FINISHED':
				$this->PayNotifyLog($request->input('out_trade_no'),'alipay',0,$request);
				// TODO: 支付成功，取得订单号进行其它相关操作。
				$this->payCompletedAction($request->input('out_trade_no'),$request->input('trade_no'),"TRADE_FINISHED","alipay");
				return 'success';
				break;
		}
	}
	
	/**
	 * 同步通知
	 */
	public function alipayReturnUrl(Request $request)
	{
		// 验证请求。
		if (! app('alipay.web')->verify()) {
			return redirect('member/accountCenter/orders')->with(['alert'=>'回调失败！']);
		}
	
		// 判断通知类型。
		switch ($request->input('trade_status')) {
			case 'TRADE_SUCCESS':
			case 'TRADE_FINISHED':
				$this->PayNotifyLog($request->input('out_trade_no'),'alipay',1,$request);
				$this->payCompletedAction($request->input('out_trade_no'),$request->input('trade_no'),"TRADE_FINISHED","alipay");
				$order = Orders::where(['order_id'=>$request->input('out_trade_no')])->first();
				return redirect('member/accountCenter/orders')->with(['buy_success'=>'支付完成！','product_id'=>$order->product_id]);
				break;
		}
		return redirect('member/accountCenter/orders')->with(['alert'=>'回调失败！']);
	}
	/*支付宝支付*/
	/*微信支付*/
	function wxpay($order){
		if(session('theme')=='default'){
			$this->json['order_id']=$order['order_id'];
			$this->json['url']=WxPay::pay('NativePay',$order);
			$this->json['status']=true;
			$this->echoJson();
		}else{
			return redirect(url('api/member/order/wxpayJsapi?order_id='.$order['order_id'].'&student_id='.$order['owner_id']));
		}
	}
	/*微信jsapi订单确认*/
	public function wxpayJsapi(Request $request){
		$check=Validator::make($request->all(),[
				'order_id'=>'required|exists:orders,order_id,status,0,owner_id,'.$request->input('student_id'),
				'student_id'=>'required|exists:students,id,parent_id,'.auth('member')->getId()
		]);
		if($check->passes()){
			$s=Students::where(['id'=>$request->input('student_id')])->first();
			$order=$order=Orders::leftjoin('students','students.id','=','orders.owner_id')
				->leftjoin('products','products.id','=','orders.product_id')
				->where(['order_id'=>$request->input('order_id')])
				->first(['orders.*','products.product_name','students.name'])
				->toArray();
			$data['head_title']="微信支付中";
			$data['order']=$order;
			$data['JsApiPay']=WxPay::pay('JsApiPay',$order);
			return view("front::mobile.pay.confirmOrder",$data);
		}else{
			if($check->errors()->has('order_id')){
				$error="订单不存在！";
			}elseif($check->errors()->has('student_id')){
				$error="孩子不存在！";
			}
			return redirect()->back()->with(['alert'=>$error]);
		}
	}
	/*微信通知*/
	public function wxpayNotifyUrl(Request $request){
		$data=WxPay::checkNotify();
		if($data['return_code']){
			$data['out_trade_no']=str_replace(WxPayConfig::MCHID,'',$data['out_trade_no']);
			$this->PayNotifyLog($data['out_trade_no'],'wxpay',0,$request);
			$this->payCompletedAction($data['out_trade_no'],$data['transaction_id'],'SUCCESS','wxpay');

			return 'SUCCESS';
		}else{
			Log::notice($data['msg']);
		}
	}
	/*微信支付*/
	/*付款完成动作*/
	public function payCompletedAction($order_id,$trade_no,$pay_status,$pay_type){
		$r=DB::select('select buy_notify("'.$order_id.'","'.$trade_no.'","'.$pay_status.'","'.$pay_type.'") as result');
		if($r[0]->result){
			$o=Orders::where(['order_id'=>$order_id])->first();
			$this->createBorrowPlan($o);
			//DiscountController::createPayDiscountForPromoter($o->id);
			//DiscountController::createPayDiscountForProduct($o->id);
			//一般会员购买产品后获得优惠券
			$member = Members::crossjoin('students as s','members.id','=','s.parent_id')->where(['s.id'=>$o->owner_id])->first(['members.*']);
			//$member=DB::table('members as m')->crossjoin('students as s','m.id','=','s.parent_id')->where(['s.id'=>$o->owner_id])->first(['m.*']);
			Discount::giveByRule($member->id, 'member_buy',['product_id'=>$o->product_id,'buy_member_id'=>$member->id],'orders_'.$o->id);
			$promoter=Promotions::where(['pcode'=>$member->pcode])->first();
			if($promoter){
				//被关联的推广员所推广的会员购买产品时，该会员获得优惠券
				Discount::giveByRule($member->id, 'promoted_member_buy_tm',['promotions_type_id'=>$promoter->type,'product_id'=>$o->product_id,'buy_member_id'=>$member->id],'orders_'.$o->id);
				//关联的推广员所推广的会员购买产品时，推广员获得优惠券
				Discount::giveByRule($promoter->member_id, 'promoted_member_buy_tp',['promotions_type_id'=>$promoter->type,'product_id'=>$o->product_id,'buy_member_id'=>$member->id],'orders_'.$o->id);
			}
			//购买产品获得积分
			PointController::increaceByRule([
					'rule'=>'buy_product',
					'product_id'=>$o->product_id,
					'student_id'=>$o->owner_id
			]);
			TimedTask::where(['unique'=>md5('star_report_created_'.$o->owner_id)])->update(['status'=>1]);
			$product=Products::where(['id'=>$o->product_id])->first();
			
			/*消息通知设置*/
				$product=Products::where(['id'=>$o->product_id])->first();
				$student=Students::where(['id'=>$o->owner_id])->first();
				$member=Members::where(['id'=>$student->parent_id])->first();
				$expirated=date("Y-m-d",strtotime(Students::getServiceExpirated($student->id,$product->service_id)));
				$sendType=0;  //消息发送流程
				
				$bladeData=[
						'student'=>$student->name,   					//购买的孩子名称
						'product'=>$product->product_name, 	//购买的产品名称
						'expirated'=>$expirated,						 	//购买的服务过期日期
						'star_account'=>null,
						'star_password'=>null,
				];
				
				/*star账号分配*/
				if($product->asign_account){ //判断是否需要分配账号
					if($product->send_account){ //判断是否需要发送
						$a=DB::select('select fun_asign_account_v3('.$student->id.') as result');
						if($a[0]->result){
							$staraccount=StarAccount::where(['id'=>$a[0]->result])->first();
							$bladeData['star_account']=$staraccount->star_account;
							$bladeData['star_password']=$staraccount->star_password;
						}else{
							//账号等待老师分配
							$sendType=1;
						}
					}else{
						//账号等待老师分配
						$sendType=1;
					}
				}
				switch($sendType){
					//账号等待老师分配
					case 1:
						$teacher=User::leftjoin('student_group','student_group.user_id','=','users.id')
							->leftjoin('students','student_group.id','=','students.group_id')
							->where(['users.role'=>3,'students.id'=>$student->id])
							->first(['users.*']);
						/*发送短信*/
						$alidayu = new AlidayuSendController();
						$alidayu->send('wait_assign_staraccount',$member->cellphone);
						/*发送站内消息*/
						if($member->email || $member->cellphone){
							Messages::sendSiteMessage('产品购买通知',"您已购买产品，等待老师发送账号",$member->cellphone?$member->cellphone:$member->email);
						}
						
						/*通知老师或指导员*/
						if($teacher){  //通知老师
							Messages::sendSiteMessage('学生购买通知',"昵称为".$student->nick_name."的学生，购买了【".$product->product_name."】需要分配star账号,分配star账号后记得通知家长哦~",$teacher->id);
						}else{
							Messages::sendSiteMessage('学生购买通知',"昵称为".$student->nick_name."的学生，购买了【".$product->product_name."】,请分配老师并叫老师分配star账号,分配star账号后记得通知家长哦~",3);
						}
						break;
				    //正常购买流程
					default:
							$bladeData['bought_times'] = $member->boughtCount($product->id,$student->id) >1;
							/*发送短信*/
							$alidayu = new AlidayuSendController();
							// 续费短信是否设置
							$seted=AlidayuMessageSetting::where(['type'=>5,'product_id'=>$product->id,'status'=>1])->whereNull('deleted_at')->count();
							if($bladeData['bought_times'] && $seted){ // 续费购买短信
								$alidayu->send('renew',$member->cellphone,[
										'product_id'=>$product->id,
										'product_name'=>$product->product_name
								]);
							}else{ //	初次购买短信
								$alidayu->send('bought',$member->cellphone,[
										'product_id'=>$product->id,
										'product_name'=>$product->product_name
								]);
							}
							/*发送邮件*/
							if($product->send_email_blade && $member->email){
								/* 获得该用户第n次购买该产品信息 */
								Messages::sendEmail("产品购买通知",$member->email,$product->send_email_blade,$bladeData);
							}
							/*发送站内消息*/
							if($product->send_site_message && ($member->email || $member->cellphone)){
								Messages::sendSiteMessage('产品购买通知',$product->send_site_message,$member->cellphone?$member->cellphone:$member->email);
							}
						StarAccount::where(['asign_to'=>$student->id,'status'=>1])->update(['notify_system'=>1]);
						
				}
		}
	}
	/**
	 * 借阅服务购买-创建计划
	 */
	public function createBorrowPlan($o){
		$p = $o->connectProduct();
		if ($p && in_array($p->service_id,[8,13])){
			$s=Students::where(['id'=>$o->owner_id])->first();
			$rp=array(
					'plan_name'=>'【'.date("Y",time())."】借阅 第".($s->countBorrowPlanCY()+1)."次",
					'from'	   =>date("Y-m-d",time()),
					'to'	   =>date("Y-m-d",time()+60*60*24*40),
					'for'	   =>$s->id,
					'status'   =>-1,
					'type' =>1
			);
			ReadPlan::create($rp);
		}else if($p && in_array($p->service_id,[15])){
			$s=Students::where(['id'=>$o->owner_id])->first();
			$rp=array(
					'plan_name'=>'【'.date("Y",time())."】寒假计划",
					'from'	   =>date("Y-m-d",time()),
					'to'	   =>date("Y-m-d",time()+60*60*24*40),
					'for'	   =>$s->id,
					'status'   =>-1,
					'type' =>2
			);
			ReadPlan::create($rp);
		}
	}
	//根据订单号查询订单状态
	public function getStatusByOID(Request $request){
		$order=Orders::where(['order_id'=>$request->input('order_id')])->first();
		if($order && $order->status==1){
			$this->json['status']=true;
		}else{
			$this->json['status']=false;
		}	
		$this->echoJson();
	}
	//订单通知日志
	public function PayNotifyLog($order_id,$pay_type,$synchronous,$request){
		$log=array(
				'order_id'=>$order_id,
				'pay_type'=>$pay_type,
				'synchronous'=>$synchronous,
				'HTTP_USER_AGENT'=>$request->server('HTTP_USER_AGENT')
		);
		PayNotifyLog::create($log);
	}
}
