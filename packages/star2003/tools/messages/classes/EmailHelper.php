<?php 
namespace Tools\Messages\Classes;
use Mail;
class EmailHelper{
	static function sendMessages($sendTo,$data,$subject,$view,$attachment=null){
		if($attachment){
			Mail::queue(self::template($view), $data, function($message) use($data,$subject,$attachment)
			{
				$message->to($data['sendto'], $data['title'])->subject($subject)->attach($attachment);
			});
		}else{
			Mail::queue(self::template($view), $data, function($message) use($data,$subject)
			{
				$message->to($data['sendto'], $data['title'])->subject($subject);
			});
		}
	}
	private static function template($template){
		switch($template){
			//注册验证
			case 'register':return 'messages::register';
			//登录验证
			case 'login':return 'messages::login';
			//修改手机号码
			case 'update':return 'messages::update';
			//star账号分配消息
			case 'star':return 'messages::star';
			//star账号分配消息-后台
			case 'starAsignBack':return 'messages::starAsignBack';
			//star报告上传消息
			case 'starreport':return 'messages::starreport';
			//付款通知
			case 'payment':return 'messages::payment';
			//一般消息
			default:
				return 'messages::default';
		}
	}
}
?>