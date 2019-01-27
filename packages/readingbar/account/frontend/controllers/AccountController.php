<?php

namespace Readingbar\Account\Frontend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Readingbar\Account\Frontend\Models\members;
use Validator;
use DB;
use App;
use Auth;
use Oauth;
use Messages;
use Readingbar\Account\Frontend\Models\Active;
use GuzzleHttp\json_encode;
class AccountController extends Controller
{
	private $guards='member';
	private $json=array();
	//登录
	public function loginView(){
		$data=array();
		if(Auth::guard('member')->isLoged()){
			$data['member']=" welcome ".Auth::guard('member')->getFiled('nickname')." come here! ";
		}
		return view("Readingbar/account/frontend::account.login",$data);
	}
	//账号密码登录
	public function loginAction(Request $request){
		if($request->input('password')!==null){
			if(Auth::guard('member')->login($request->input('account'),$request->input('password'))){
				return redirect()->back();
			}else{
				return redirect("account/login")
				->withErrors(array('login'=>'账号不存在或密码错误!'))
				->withInput();
			}
		}else{
			if(Auth::guard('member')->loginByMessage($request->input('account'),$request->input('logincode'))){
				return redirect()->back();
			}else{
				return redirect("account/login")
				->withErrors(array('login'=>'账号不存在或验证码错误!'))
				->withInput();
			}
		}
	}
	//发送登录消息
	public function sendLoginMessage(Request $request){
		$r=Auth::guard('member')->sendLoginMessage($request->input('account'));
		if($r){
			$this->json=array('statues'=>true,"msg"=>"消息已发送！");
		}else{
			$this->json=array('statues'=>false,"msg"=>"用户名不存在！");
		}
		echo json_encode($this->json);
	}
	public function logoutAction(){
		Auth::guard('member')->logout();
		return redirect("account/login");
	}
	//账号注册
	public function registerView($step=1){
		$register=session('register');
		switch ($step){
			case 1:session()->forget('register');break;
			case 2:
				if(!isset($register['complete_step'][1]) || !$register['complete_step'][1]){
					return redirect('account/register/1');
				}
				break;
			case 3:
				if(!isset($register['complete_step'][2]) ||!$register['complete_step'][2]){
					return redirect('account/register/2');
				}
				break;
			case 4:
				if(!isset($register['complete_step'][3]) ||!$register['complete_step'][3]){
					return redirect('account/register/3');
				}
				break;
		}
		$data['step']=$step;
		return view("Readingbar/account/frontend::account.register_step".$step,$data);
	}
	public function registerAction(Request $request){
		$register=session('register');
		switch ($request->input('step')){
			//协议
			case 1:
				if($request->input('license')){
					$register['complete_step'][1]=true;
					session(['register'=>$register]);
					return redirect('account/register/2');
				}else{
					return redirect('');
				}
				break;
			//账号
			case 2:
				//输入账号校验
				$account=Validator::make([
						'account'=>$request->input('account'),
						'cellphone'=>$request->input('account'),
						'email'=>$request->input('account')
					],
					[
						'account'=>'required',
						'cellphone'=>'regex:/^[1][358][0-9]{9}$/',
						'email'=>'regex:/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/'
					]);
				//判断账号是否为空
				if(!$account->errors()->has('account')){
					//判断账号格式 （手机，邮箱）
					if(!$account->errors()->has('cellphone') || !$account->errors()->has('email')){
						//手机格式时执行
						if(!$account->errors()->has('cellphone')){
							//数据唯一性校验
							$enable=Validator::make(['cellphone'=>$request->input('account')],
								[
									'cellphone'=>'required|numeric|unique:members,cellphone'
								]);
						}
						//邮箱格式格式时执行
						if(!$account->errors()->has('email')){
							//数据唯一性校验
							$enable=Validator::make(['email'=>$request->input('account')],
								[
									'email'=>'required|email|unique:members,email'
								]);
						}
						//判断数据唯一性
						if($enable->fails()){
							return redirect('account/register/2')
							->withErrors(array('account'=>trans('F_account.error_account_exist')))
							->withInput();
						}else{
							$re=DB::select("CALL sp_InsertMember('".$request->input('account')."');");
							$active=Active::where('active','=',$request->input('account'))->where('actived','<>',1)->first();
							$this->sendActiveCode($active['active_code'],$request->input('account'));
							$register['complete_step'][2]=true;
							$register['account']=$request->input('account');
							$register['member_id']=$re[0]->id;
							session(['register'=>$register]);
							return redirect('account/register/3');
						}
					}else{
						return redirect('account/register/2')
						->withErrors(array('account'=>trans('F_account.error_account_format')))
						->withInput();
					}
				}else{
					return redirect('account/register/2')
					->withErrors($account)
					->withInput();
				}
				break;
			//验证码
			case 3:
		//验证消息
				$code=Validator::make(
				[
					'code'=>$request->input('code')
				], [
					'code' => 'required|numeric|exists:active,active_code,active,'.$register['account'].',actived,0'
				]);
				if(!$code->fails()){
					Active::where('active','=',$register['account'])->update(array('actived'=>1));
					$register['complete_step'][3]=true;
					session(['register'=>$register]);
					return redirect('account/register/4');
				}else{
					return redirect('account/register/3')
					->withErrors($code)
					->withInput();
				}
				break;
			//密码昵称
			case 4:
				$register=session('register');
				$memberV=Validator::make($request->all(),
					[
						'nickname'=>'required|unique:members',
						'password'=>'required|min:6|confirmed'	
					]);
				if(!$memberV->fails()){
					$member=array(
						'nickname'=>$request->input('nickname'),
						'password'=>bcrypt($request->input('password')),
						'actived'=>1
					);
					Members::where('id','=',$register['member_id'])->update($member);
					return redirect('account/login');
				}else{
					return redirect('account/register/4')
					->withErrors($memberV)
					->withInput();
				}
				break;
			default:abort(404);
		}
	}
	//密码找回
	public function forgotenView($step=1){
		$forgoten=session('forgoten');
		switch ($step){
			case 1:session()->forget('forgoten');break;
			case 2:
				if(!isset($forgoten['complete_step'][1]) || !$forgoten['complete_step'][1]){
					return redirect('account/forgoten/1');
				}
				$data['find_way']=$forgoten['find_way'];
				if($data['find_way']=='qa'){
					$member=Members::where($forgoten['type'],'=',$forgoten['account'])->first();
					$data['question']=$member->question;
				}
				break;
			case 3:
				if(!isset($forgoten['complete_step'][2]) || !$forgoten['complete_step'][2]){
					return redirect('account/forgoten/2');
				}
			break;
		}
		$data['step']=$step;
		
		return view('Readingbar/account/frontend::account.forgoten_step'.$step,$data);
	}
	public function forgotenAction(Request $request){
		$forgoten=session('forgoten');
		switch ($request->input('step')){
			//账号
			case 1:
				//输入账号校验  
				$account=Validator::make([
						'account'=>$request->input('account'),
						'cellphone'=>$request->input('account'),
						'email'=>$request->input('account')
					],
					[
						'account'=>'required',
						'cellphone'=>'regex:/^[1][358][0-9]{9}$/',
						'email'=>'regex:/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/',
					]);
				//判断用户名是否为空
				if(!$account->errors()->has('account')){
					//判断用户名格式（手机,邮箱）
					if(!$account->errors()->has('cellphone') || !$account->errors()->has('email')){
						//手机格式时执行
						if(!$account->errors()->has('cellphone')){
							$mobile=Validator::make(['cellphone'=>$request->input('account')], [
								'cellphone' => 'required|numeric|exists:members,cellphone',
							]);
							if($mobile->fails()){
								return redirect('account/forgoten/1')
								->withErrors($mobile)
								->withInput();
							}
							$forgoten['type']='cellphone';
						}
						//邮箱格式时执行
						if(!$account->errors()->has('email')){
							$email=Validator::make(['email'=>$request->input('account')], [
									'email' => 'required|email|exists:members,email',
							]);
							if($email->fails()){
								return redirect('account/forgoten/1')
								->withErrors($email)
								->withInput();
							}
							$forgoten['type']='email';
						}
						//记录第一步完成    记录 账号信息      生成手机验证码 记录数据库
						$forgoten['complete_step'][1]=true;
						$forgoten['account']=$request->input('account');
						//记录密码找回方式  默认消息找回
						if($request->input('find_way') && in_array($request->input('find_way'),array('message','qa'))){
							$forgoten['find_way']=$request->input('find_way');
						}else{
							$forgoten['find_way']='message';
						}
						//消息找回方式下生成验证码
						if($forgoten['find_way']=='message'){
							$forgoten['r_code']=rand(10000,999999);
							switch ($forgoten['type']){
								case 'cellphone':$message_type='sms';break;
								case 'email':$message_type='email';break;
							}
							$this->sendActiveCode($forgoten['r_code'], $forgoten['account'],$message_type);
						}
						session(['forgoten'=>$forgoten]);
						
						return redirect('account/forgoten/2');
					}else{
						return redirect('account/forgoten/1')
						->withErrors(array('account'=>trans('F_account.error_account_format')))
						->withInput();
					}
				}else{
					return redirect('account/forgoten/1')
					->withErrors($account)
					->withInput();
				}
				break;
			//消息验证  || 问题验证
			case 2:
				switch ($forgoten['find_way']){
					case 'message':
						//验证消息
						$code=Validator::make(
								[
									'code'=>(int)$request->input('code'),
									'r_code'=>$forgoten['r_code']
								], [
									'code' => 'required|numeric|same:r_code'
								]);
						if($code->fails()){
							return redirect('account/forgoten/2')
							->withErrors($code)
							->withInput();
						}
						break;
					case 'qa':
						//问题验证
						$answer=Validator::make(
								[
									'answer'=>$request->input('answer')
								], [
									'answer' => 'required|exists:members,answer,'.$forgoten['type'].','.$forgoten['account']
								]);
						if($answer->fails()){
							return redirect('account/forgoten/2')
							->withErrors($answer)
							->withInput();
						}
						break;
					default:exit('you operation is error!');
				}
				//记录完成步骤
				$forgoten['complete_step'][2]=true;
				session(['forgoten'=>$forgoten]);
				
				return redirect('account/forgoten/3');
				break;
			case 3:
				//验证密码
				$password=Validator::make($request->all(), [
					'password' => 'required|min:6|confirmed'
				]);
				if($password->fails()){
					return redirect('account/forgoten/3')
					->withErrors($password)
					->withInput();
				}
				//保存用户密码
				$member['password']=bcrypt($request->input('password'));
				$member[$forgoten['type']]=$forgoten['account'];
				Members::where($forgoten['type'],'=',$forgoten['account'])->update($member);

				//清除找回密码时输入的数据
				session()->forget('forgoten');
				return redirect('account/login');
				break;
		}
	}
	public function OAuthLogin($service){
		$user=Oauth::service($service)->user();
		switch($service){
			case 'QQ':$column='QQopenid';break;
		}
		$validator = Validator::make(
				[
					'openid'	=>$user['openid'],
				], [
					'openid'	=>'required|exists:members,'.$column,
				]);
		if($validator->fails()){
			$nickname=$user['nickname'];
			do{
				$chekcnickname=Validator::make(
						[
						'nickname'	=>$nickname,
						], [
						'nickname'	=>'required|unique:members,nickname',
						]);
				if($chekcnickname->fails()){
					$nickname=$nickname."_QQ".rand(100000,999999);
				}
			}while($chekcnickname->fails());
			$member=Members::create(array($column=>$user['openid'],'nickname'=>$nickname,'actived'=>1));
		}else{
			$member=Members::where(array($column=>$user['openid']))->first();
		}
		session(['member'=>$member]);
		if(session('url.intended')){
			$redirect=session('url.intended');
			session()->forget('url.intended');
			return redirect($redirect);
		}else{
			return redirect('account/login');
		}
	}
	public function sendActiveCode($code,$sendto,$message_type='email'){
		Messages::sendMessage($sendto,"please active","active_code:".$code,$message_type);
	}
}