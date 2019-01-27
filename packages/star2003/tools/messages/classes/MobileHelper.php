<?php 
namespace Tools\Messages\Classes;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
class MobileHelper{
	private $appkey='23492448';
	private $app_secret='bec0e86e6733017e23a79dc331e77f50';
	static function sendMessages($sendTo,$data,$template){
		$config = [
		    'app_key'    => config('alidayu.appkey'),
		    'app_secret' => config('alidayu.app_secret')
		];
		$client = new Client(new App($config));
		$req    = new AlibabaAliqinFcSmsNumSend;
		$template=self::template($template,$data);
		$req->setRecNum($sendTo)
		    ->setSmsParam($template['SmsParam'])
		    ->setSmsFreeSignName($template['SmsFreeSignName'])
		    ->setSmsTemplateCode($template['SmsTemplateCode']);
		$resp = $client->execute($req);
		//print_r($resp);
		//print_r($resp->result->model);
	}
	private static function template($template,$data){
		switch($template){
			//注册验证
			case 'register':
				return $t=array(
					'SmsFreeSignName'=>'蕊丁吧',
					'SmsTemplateCode'=>'SMS_22360004',
					'SmsParam'=>array(
							'code'=>$data['content'],
							'product'=>'readingbar'
						)
				);
			//登录验证
			case 'login':
				return $t=array(
					'SmsFreeSignName'=>'蕊丁吧',
					'SmsTemplateCode'=>'SMS_22360006',
					'SmsParam'=>array(
							'code'=>$data['content'],
							'product'=>'readingbar'
						)
				);
			//修改手机号码
			case 'update':
				return $t=array(
					'SmsFreeSignName'=>'蕊丁吧',
					'SmsTemplateCode'=>'SMS_22360001',
					'SmsParam'=>array(
							'code'=>$data['content'],
							'product'=>'readingbar'
						)
				);
			//测试账号发送提醒
			case 'star':
				return $t=array(
					'SmsFreeSignName'=>'蕊丁吧',
					'SmsTemplateCode'=>'SMS_25745135',
					'SmsParam'=>null
				);
			//测试报告上传消息
			case 'starreport':
				return $t=array(
					'SmsFreeSignName'=>'蕊丁吧',
					'SmsTemplateCode'=>'SMS_25680371',
					'SmsParam'=>null
				);
			//还书通知
			case 'returnBook':
				return $t=array(
				'SmsFreeSignName'=>'蕊丁吧',
				'SmsTemplateCode'=>'SMS_27340218',
				'SmsParam'=>null
				);
			//书籍配送提醒
			case 'bookDistribution':
				return $t=array(
				'SmsFreeSignName'=>'蕊丁吧',
				'SmsTemplateCode'=>'SMS_27470156',
				'SmsParam'=>null
				);
			//阅读计划提醒
			case 'readplanConfirm':
				return $t=array(
				'SmsFreeSignName'=>'蕊丁吧',
				'SmsTemplateCode'=>'SMS_27335214',
				'SmsParam'=>null
				);
			//用户未付款通知
			case 'notpayment':
				return $t=array(
				'SmsFreeSignName'=>'蕊丁吧',
				'SmsTemplateCode'=>'SMS_27365357',
				'SmsParam'=>null
				);
			//用户产品付款通知
			case 'payment':
				return $t=array(
				'SmsFreeSignName'=>'蕊丁吧',
				'SmsTemplateCode'=>'SMS_27355271',
				'SmsParam'=>array(
							'product_name'=>$data['product_name']
						)
				);
			//用户产品付款通知-孩子没有可分配的账号
			case 'payment-unAsignStarAccount':
				return $t=array(
				'SmsFreeSignName'=>'蕊丁吧',
				'SmsTemplateCode'=>'SMS_27440192',
				'SmsParam'=>null
				);
			//用户产品付款通知-单次star评测产品短信通知
			case 'payment-singleStarAccount':
				return $t=array(
				'SmsFreeSignName'=>'蕊丁吧',
				'SmsTemplateCode'=>'SMS_46680066',
				'SmsParam'=>array(
					'product_name'=>$data['content']
				)
			);
			//后台账号分配通知
			case 'starAsignBack':
				return $t=array(
				'SmsFreeSignName'=>'蕊丁吧',
				'SmsTemplateCode'=>'SMS_25745135',
				'SmsParam'=>null
			);
			//一般消息
			default:
				return $t=array(
					'SmsFreeSignName'=>'蕊丁吧',
					'SmsTemplateCode'=>'SMS_22360004',
					'SmsParam'=>array(
							'code'=>$data['content'],
							'product'=>'readingbar'
						)
			);
		}
	}
}
?>