<?php 
namespace Readingbar\Account\Frontend\Guard;
use Validator;
use Readingbar\Account\Frontend\Models\Members;
use Messages;
class MemberGuard{
	public $member=null;
	public $app;
	public function __construct($app){
		$this->member=session('member');
		$this->app = $app;
	}
	//一般登录
	public function login($account,$password){
		//账号校验
		$check=Validator::make([
			'cellphone'=>$account,
			'email'=>$account
		],
		[
			'cellphone'=>'required|regex:/^[1][358][0-9]{9}$/|exists:members,cellphone,actived,1',
			'email'=>'required|regex:/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/|exists:members,email,actived,1'
		]);
		
		if(!$check->errors()->has('email') || !$check->errors()->has('cellphone')){
			if(!$check->errors()->has('email')){
				$member=Members::where('email','=',$account)->first();
			}
			if(!$check->errors()->has('cellphone')){
				$member=Members::where('cellphone','=',$account)->first();
			}
			//密码校验
			$r=password_verify($password,$member->password);
			
			if($r){
				session(['member'=>$member]);
				$this->member=session('member');
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	//验证消息登录
	public function loginByMessage($account,$code){
		//账号校验
		$check=Validator::make([
			'cellphone'=>$account,
			'email'=>$account
		],
		[
			'cellphone'=>'required|regex:/^[1][358][0-9]{9}$/|exists:members,cellphone,actived,1',
			'email'=>'required|regex:/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/|exists:members,email,actived,1'
		]);
		
		if((!$check->errors()->has('email') || !$check->errors()->has('cellphone')) && session('loginMessage')){
			$loginMessage=session('loginMessage');
			if($account==$loginMessage['account'] && $loginMessage['code']==$code){
				if(!$check->errors()->has('email')){
					$member=Members::where('email','=',$account)->first();
				}
				if(!$check->errors()->has('cellphone')){
					$member=Members::where('cellphone','=',$account)->first();
				}
				session(['member'=>$member]);
				$this->member=session('member');
				return true;
			}else{
				return false;
			};
		}else{
			return false;
		}
	}
	//发送登录消息
	public function sendLoginMessage($account){
		//账号校验
		$check=Validator::make([
				'cellphone'=>$account,
				'email'=>$account
				],
				[
				'cellphone'=>'required|regex:/^[1][358][0-9]{9}$/|exists:members,cellphone,actived,1',
				'email'=>'required|regex:/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/|exists:members,email,actived,1'
				]);
		if((!$check->errors()->has('email') || !$check->errors()->has('cellphone'))){
			$loginmessage=array("code"=>rand(000000,999999),"account"=>$account);
			if(!$check->errors()->has('email')){
				$message_type='email';
			}elseif (!$check->errors()->has('cellphone')){
				$message_type='sms';
			}
			session(['loginMessage'=>$loginmessage]);
			Messages::sendMessage($account,"消息登录验证","验证码:".$loginmessage['code'],$message_type);
			return true;
		}else{
			return false;
		}
	}
	public function logout(){
		session()->forget('member');
		$this->member=null;
	}
	public function member(){
		return $this->member;
	}
	public function isLoged(){
		if($this->member){
			return true;
		}else{
			return false;
		}
	}
	public function getFiled($filed){
		if(isset($this->member[$filed])){
			return $this->member[$filed];
		}else{
			return null;
		}
	}
	public function getId(){
		if(isset($this->member['id'])){
			return $this->member['id'];
		}else{
			return null;
		}
	}
	public function reflush(){
		$member=Members::where('id','=',$this->getId())->first();
		session(['member'=>$member]);
		$this->member=session('member');
	}
}
?>