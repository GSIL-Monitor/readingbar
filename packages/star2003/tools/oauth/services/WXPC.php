<?php 
namespace Tools\Oauth\Services;
class WXPC{
	public $requestWeb=array(
		'code'=>'https://open.weixin.qq.com/connect/qrconnect',
		'token'=>'https://api.weixin.qq.com/sns/oauth2/access_token',
		'get_user_info'=>'https://api.weixin.qq.com/sns/userinfo'
	);
	public $response_type='code';
	public $client_id; //APPID
	public $client_secret; //APPKEY
	public $redirect_uri;
	public $grant_type='authorization_code';
	//获取的信息
	public $code;
	public $access_token;
	public $unionid;
	public $openid;
	public $user;
	
	public function __construct(){
		header("Content-type: text/html; charset=utf-8");
		$this->redirect_uri=config('services.WXPC.redirect');
		$this->client_id=config('services.WXPC.client_id');
		$this->client_secret=config('services.WXPC.client_secret');
	}
	
	public function redirect(){
		$state=rand(100000,999999);
		$url=$this->requestWeb['code'];
		$url.='?redirect_uri='.$this->redirect_uri;
		$url.='&appid='.$this->client_id;
		$url.='&response_type='.$this->response_type;
		$url.='&scope=snsapi_login';
		$url.='&state='.$state;
		$url.='#wechat_redirect';
		session(['OAuth_state'=>$state]);
		return redirect($url);
	}
	public function user(){
		if($this->checkState()){
			$this->getCode();
			$this->getAccessToken();
			$url=$this->requestWeb['get_user_info'];
			$url.='?access_token='.$this->access_token;
			$url.='&scope=snsapi_userinfo';
			$url.='&openid='.$this->openid;
			
			$user=json_decode($this->curl($url));
			if (isset($access_token->errcode)){
				echo '【微信错误】','错误码：',$access_token->errcode,';错误信息:',$access_token->errmsg;
			}
			return (array)$user;
		}
	}
	public function checkState(){
		// 校验
		if (isset($_GET['state'])) {
			if ($_GET['state']==session('OAuth_state')) {
				session()->forget('OAuth_state');
				return true;
			}
			return false;
		} else {
			return false;
		}
	}
	public function getCode(){
		if(!isset($_GET['code'])){
			exit('code 不存在!');
		}
		$this->code=$_GET['code'];
	}
	public function getAccessToken(){
		$url=$this->requestWeb['token'];
		$url.='?grant_type='.$this->grant_type;
		$url.='&appid='.$this->client_id;
		$url.='&secret='.$this->client_secret;
		$url.='&code='.$this->code;
		$access_token_info=$this->curl($url);
		$access_token=json_decode($access_token_info);
		if (isset($access_token->errcode)){
			echo '【微信错误】','错误码：',$access_token->errcode,';错误信息:',$access_token->errmsg;
		}
		$this->access_token=$access_token->access_token;
		$this->unionid=$access_token->unionid;
		$this->openid=$access_token->openid;
	}
	public function curl($url){
		//初始化
		$ch = curl_init();
		//设置选项，包括URL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 信任任何证书
		//执行并获取HTML文档内容
		$output = curl_exec($ch);
		//释放curl句柄
		curl_close($ch);
		//打印获得的数据
		return $output;
	}
}
?>