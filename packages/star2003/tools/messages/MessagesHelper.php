<?php 
namespace Tools\Messages;
use Tools\Messages\Classes\EmailHelper;
use Tools\Messages\Classes\MobileHelper;
use Tools\Messages\Models\Messages;
use Mail;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
class MessagesHelper{
	private $app;
	public function __construct($app){
		$this->app=$app;
	}
	/**
	 * 
	 * @param unknown $sendTo
	 * @param unknown $title
	 * @param unknown $content
	 * @param string $message_type 
	 * @param unknown $template  消息模板:login,register,update,default
	 * @param string $sendFrom
	 */
	function sendMessage($sendTo,$title,$content,$message_type='email',$template='messages::default',$sendFrom='system',$attachment=null){
		$message=$data=array(
				'title'=>$title,
				'content'=>$content,
				'sendto'=>$sendTo,
				'sendfrom'=>$sendFrom,
				'message_type'=>$message_type
		);
		$content=$this->saveContent($template, $data);
		$data['content']=$content?$content:$message['content'];
		Messages::Create($data);
		switch($message_type){
			case 'email':$this->email($sendTo,$message,$title,$template,$attachment);break;
			case 'sms':$this->mobile($sendTo,$message,$template);break;
		}
	}
	public function email($sendTo,$data,$subject,$template,$attachment=null){
		EmailHelper::sendMessages($sendTo,$data,$subject,$template,$attachment);
	}
	public function mobile($sendTo,$data,$template){
		MobileHelper::sendMessages($sendTo,$data,$template);
	}
	/**
	 * 向所有的联系发送消息
	 * */
	function sendMessageForAllConections($conections,$subject,$data,$template="default",$sendFrom='system',$attachment=null){
		if(isset($conections['email'])){
			$data['sendto']=$sendto=$conections['email'];
			$data['title']=$subject;
			$this->email($conections['email'], $data, $subject, $template,$attachment);
			
		}
		if(isset($conections['sms'])){
			$data['sendto']=$sendto=$conections['sms'];
			$data['title']=$subject;
			$this->mobile($conections['sms'], $data, $template);
		}
		$content=$this->saveContent($template, $data);
		$message=array(
				'title'=>$subject,
				'content'=>$content,
				'sendto'=>$sendto,
				'sendfrom'=>$sendFrom,
				'message_type'=>'all'
		);
		Messages::Create($message);
	}
	//数据库保存信息
	function saveContent($template,$data){
		$content='';
		switch($template){
			case 'star':$content="您的孩子".$data['student']."star申请成功！账号：".$data['account'].";密码：".$data['password'];break;
			case 'starreport':$content="【蕊丁吧】亲爱的家长，您好！感谢您使用专业阅读能力测评系统，您的测试报告已生成，您可以登陆登陆蕊丁吧官网个人用户中心-我的报告中查询。";break;
			case 'payment'	 :$content="亲爱的家长，您好！欢迎您成为蕊丁吧“".$data['product_name']."”会员，您的正式测评账号和密码信息已发送至您的邮箱，请注意查收，谢谢！";break;
			case 'payment-unAsignStarAccount':$content="提示：您已经购买成功，请等待老师分配账号！";break;
			case 'payment-singleStarAccount':$content="提示：您已经成功购买【".$data['content']."】，请等待老师分配账号，账号会在一个工作日内发送到您的邮箱，请注意查收。祝您测评顺利！(*^__^*)";break;
			case 'readplanConfirm'  :$content="【蕊丁吧】亲爱的家长，您好！您本月的阅读计划已生成，请您登录蕊丁吧官网个人用户中心-阅读计划中查询并确认。如24小时内未确认，我们将按照此阅读计划配送。";break;
			case 'bookDistribution':$content="【蕊丁吧】亲爱的家长，您好！您本月的图书已经开始配送，请注意查收。";break;
			case 'returnBook':$content="【蕊丁吧】亲爱的家长，您好！您已申请返还图书，取货员将尽快与您联系，确认取货时间，请保持手机的畅通。";break;
			case 'register':;
			case 'login':;
			case 'update':$content="验证码：".$data['content'];break;
			case 'starAsignBack':$content='老师账号已分配，账号已发送至邮箱，请注意查收！';
		}
		return $content;
	}
	
	
	/*2017  重写*/
	/**
	 * 发送手机短信
	 */
	public function sendMobile($mobile,$param,$mobileCode,$mobileSign='蕊丁吧'){
		$config = [
				'app_key'    => config('alidayu.appkey'),
				'app_secret' => config('alidayu.app_secret')
		];
		$client = new Client(new App($config));
		$req    = new AlibabaAliqinFcSmsNumSend;
		$req->setRecNum($mobile)
			->setSmsParam($param)
			->setSmsFreeSignName($mobileSign)
			->setSmsTemplateCode($mobileCode);
		$resp = $client->execute($req);
		if(isset($resp->msg)){
			dd($resp);
		}
	}
	/**
	 * 发送email
	 */
	public function sendEmail($subject,$email,$view,$param,$attachments=array()){
		Mail::queue($view, $param, function($message) use($email,$param,$subject,$attachments)
		{
			$message->to($email, $subject)->subject($subject);
		});
	}
	/**
	 *  发送站内通知
	 * @param string $type
	 */
	public function sendSiteMessage($subject,$message,$sendto,$receiver_del=false,$sender_del=false,$sendFrom='system',$type='site'){
			$message=$data=array(
					'title'=>$subject,
					'content'=>$message,
					'sendto'=>$sendto,
					'sendfrom'=>$sendFrom,
					'message_type'=>$type,
					'receiver_del'=>$receiver_del?1:0,
					'sender_del'=>$sender_del?1:0
			);
			Messages::Create($data);
	}
}
?>