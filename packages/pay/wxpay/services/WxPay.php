<?php 
	namespace Packages\Pay\Wxpay\Services;
	use Packages\Pay\Wxpay\Services\WxPayJsApiPay;
	use Packages\Pay\Wxpay\Sdk\WxPayUnifiedOrder;
	use Packages\Pay\Wxpay\Sdk\WxPayApi;
	use Packages\Pay\Wxpay\Sdk\WxPayConfig;
	use Packages\Pay\Wxpay\Services\WxPayNativeNotify;
	use Log;
	class WxPay{
		static function pay($type,$order){
			//统一订单
			if($type=='NativePay'){
				$inputs = new WxPayUnifiedOrder();
				$inputs->SetBody("蕊丁吧-".$order['product_name']);
				$inputs->SetAttach($order['product_name']);
				$inputs->SetOut_trade_no(WxPayConfig::MCHID.$order['order_id']);
				$inputs->SetTotal_fee($order['total']*100);
				$inputs->SetTime_start(date("YmdHis"));
				$inputs->SetGoods_tag($order['product_name']);
				$inputs->SetNotify_url('https://www.readingbar.net/api/order/wxpayNotifyUrl');
				$inputs->SetTrade_type("NATIVE");
				$inputs->SetProduct_id("0");
			}else{
				$inputs = new WxPayUnifiedOrder();
// 				$inputs->SetBody("蕊丁吧-".$order['product_name']);
// 				$inputs->SetAttach($order['product_name']);
				$inputs->SetBody("bodyreadingbar");
				$inputs->SetAttach("attachreadingbar");
				$inputs->SetOut_trade_no(WxPayConfig::MCHID.$order['order_id']);
				$inputs->SetTotal_fee($order['total']*100);
				$inputs->SetTime_start(date("YmdHis"));
				//$inputs->SetGoods_tag($order['product_name']);
				$inputs->SetGoods_tag("SetGoods_tag readingbar");
				$inputs->SetNotify_url('https://www.readingbar.net/api/order/wxpayNotifyUrl');
				$inputs->SetTrade_type("JSAPI");
				$inputs->SetProduct_id("0");
			}
			return self::$type($inputs);
		}
		/*微信端支付*/
		static function JsApiPay($order){
			$WxPayJsApiPay=new WxPayJsApiPay();
			$openid=$WxPayJsApiPay->GetOpenid();
			$order->SetOpenid($openid);
			$order = WxPayApi::unifiedOrder($order);
			$data['jsApiParameters'] = $WxPayJsApiPay->GetJsApiParameters($order);
			return $data;
		}
		/*扫码支付*/
		static function NativePay($order){
			$WxPayNativePay=new WxPayNativePay();
			$r=$WxPayNativePay->GetPayUrl($order);
			return url('QrCode?param='.urlencode($r['code_url']));
		}
		/*通知校验*/
		static function checkNotify(){
			$notify=new WxPayNativeNotify();
			$notify->Handle(true);
			if($notify->GetReturn_code()=='SUCCESS'){
				$data=$notify->GetValues();
				$data['return_code']=true;
				return $data;
			}else{
				return array(
					'return_code'=>false,
					'msg'	=>$notify->GetReturn_msg()
				);
			}
		}
	}
?>