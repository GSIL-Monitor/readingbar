<?php 
namespace Tools\Oauth\Services;
class QQ{
	public $requestWeb=array(
		'code'=>'https://graph.qq.com/oauth2.0/authorize',
		'token'=>'https://graph.qq.com/oauth2.0/token',
		'me'=>'https://graph.qq.com/oauth2.0/me',
		'get_user_info'=>'https://graph.qq.com/user/get_user_info'
	);
	public $response_type='code';
	public $client_id; //APPID
	public $client_secret; //APPKEY
	public $redirect_uri;
	public $grant_type='authorization_code';
	//获取的信息
	public $code;
	public $access_token;
	public $openid;
	public $user;
	
	public function __construct(){
		header("Content-type: text/html; charset=utf-8");
		$this->redirect_uri=config('services.QQ.redirect');
		$this->client_id=config('services.QQ.client_id');
		$this->client_secret=config('services.QQ.client_secret');
	}
	
	public function redirect(){
		$state=rand(100000,999999);
		$url=$this->requestWeb['code'];
		$url.='?response_type='.$this->response_type;
		$url.='&client_id='.$this->client_id;
		$url.='&redirect_uri='.$this->redirect_uri;
		$url.='&state='.$state;
		session(['OAuth_state'=>$state]);
		return redirect($url);
	}
	public function user(){
		if($this->checkState()){
			$this->getCode();
			$this->getAccessToken();
			$this->getOpenid();
			$url=$this->requestWeb['get_user_info'];
			$url.='?access_token='.$this->access_token;
			$url.='&oauth_consumer_key='.$this->client_id;
			$url.='&openid='.$this->openid;
			
			$user_info=$this->curl($url);
			
			if(strpos($user_info,'error') || $user_info==''){
				exit($user_info);
			}
			$user=json_decode($user_info,true);
			$user['openid']=$this->openid;
			$user['access_token']=$this->access_token;
			return $user;
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
		$url.='&client_id='.$this->client_id;
		$url.='&client_secret='.$this->client_secret;
		$url.='&redirect_uri='.$this->redirect_uri;
		$url.='&code='.$this->code;
		$access_token_info=$this->curl($url);
		$access_token=array();
		if(strpos($access_token_info,'error')|| $access_token==''){
			exit("QQ接口反馈：".$access_token_info);
		}
		foreach (explode('&',$access_token_info) as $ps){
			$ps=explode('=',$ps);
			$access_token[$ps[0]]=$ps[1];
		}
		$this->access_token=$access_token['access_token'];
	}
	public function getOpenid(){
		$url=$this->requestWeb['me'];
		$url.='?access_token='.$this->access_token;
		$open_id_info=$this->curl($url);
		$open_id=array();
		if(strpos($open_id_info,'error') || $open_id_info==''){
			exit("QQ接口反馈：".$open_id_info);
		}
		$lpos = strpos($open_id_info, "(");
		$rpos = strpos($open_id_info, ")");
		$open_id = json_decode(substr($open_id_info, $lpos+1, $rpos-$lpos-1),true);
		$this->openid=$open_id['openid'];
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