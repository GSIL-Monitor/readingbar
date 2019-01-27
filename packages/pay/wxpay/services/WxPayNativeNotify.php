<?php
namespace Packages\Pay\Wxpay\Services;
use Packages\Pay\Wxpay\Sdk\WxPayApi;
use Packages\Pay\Wxpay\Sdk\WxPayNotify;
use Packages\Pay\Wxpay\Sdk\WxPayUnifiedOrder;
use Packages\Pay\Wxpay\Sdk\WxPayConfig;
use Log;
class WxPayNativeNotify extends WxPayNotify
{
	public function NotifyProcess($data, &$msg)
	{
		foreach ($data as $k=>$v){
			$this->SetData($k,$v);
		}
		return true;
	}
}