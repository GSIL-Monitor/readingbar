<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Readingbar\Api\Functions\MemberFunction;
use Auth;
use Oauth;
use Readingbar\Api\Frontend\Models\Members;
use Readingbar\Back\Controllers\Spoint\PointController;
use Readingbar\Back\Models\Students;
class LoginController extends FrontController
{
	/*密码验证登录*/
	public function loginByPassword(Request $request){
		$check=Validator::make($request->all(),[
			'username'=>"required",
			'password'=>"required",
		]);
		if($check->passes() && MemberFunction::activedUsername($request->input('username'))){
			$column=MemberFunction::checkUsernameType($request->input('username'));
			if($column!='undefined'){
				$member=Members::where([$column=>$request->input('username')])->first();
				//校验密码
				$r=password_verify($request->input('password'),$member->password);
				if($r){
					auth('member')->loginUsingId($member->id,$request->input('remember_me'));
					$this->givePoint();
					$this->json=array('status'=>true,'success'=>'登录成功！');
				}else{
					$this->json=array('status'=>false,'error'=>'用户名或密码错误！');
				}
			}else{
				$this->json=array('status'=>false,'error'=>'用户名格式错误！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'用户名或密码错误！');
		}
		$this->json['login_type']=0;
		if ($request->ajax()){
			if ($this->json['status']) {
				return ['message'=>'登录成功！'];
			}else{
				return response(['message'=>$this->json['error']],400);
			}
		}else{
			if ($this->json['status']) {
				return redirect()->intended();
			}else{
				return redirect('/login')->with($this->json);
			}
		}
	}
	/*消息验证登录*/
	public function loginByCode(Request $request){
		$check=Validator::make($request->all(),[
				'username'=>"required",
				'code'=>"required",
			]);
		if($check->passes() && MemberFunction::activedUsername($request->input('username'))){
			$column=MemberFunction::checkUsernameType($request->input('username'));
			if($column!='undefined'){
				$member=Members::where([$column=>$request->input('username')])->first();
				//校验验证码
				if($logincode=session('logincode')){
					if($logincode['expire']<time()){
						$this->json=array('status'=>false,'error'=>'验证码已失效，请重新发送！');
					}else
						if($request->input('code')==$logincode['code'] && $request->input('username')==$logincode['username']){
							session()->forget('logincode');
							auth('member')->loginUsingId($member->id,$request->input('remember_me'));
							$this->givePoint();
							$this->json=array('status'=>true,'success'=>'登录成功！');
						}else{
							$this->json=array('status'=>false,'error'=>'用户名或验证码错误！');
						}
				}else{
					$this->json=array('status'=>false,'error'=>'请发送验证码！');
				}
			}else{
				$this->json=array('status'=>false,'error'=>'用户名格式错误！');
			}
		}else{
			$this->json=array('status'=>false,'error'=>'用户名或验证码错误！');
		}
		$this->json['login_type']=1;
		if ($request->ajax()){
			if ($this->json['status']) {
				return ['message'=>'登录成功！'];
			}else{
				return response(['message'=>$this->json['error']],400);
			}
		}else{
			if ($this->json['status']) {
				return redirect()->intended();
			}else{
				return redirect('/login')->with($this->json);
			}
		}
	}
	/*第3方验证登录*/
	public function loginByOauth(Request $request,$service){
		$member=null;
		switch ($service){ 
			case 'QQ':$member=$this->loginByQQ();break;
			case 'WXPC':$member=$this->loginByWXPC();break;
			case 'WXWAP':$member=$this->loginByWXWAP();break;
		}
		if($member){
			auth('member')->loginUsingId($member->id,$request->input('remember_me'));
			$this->givePoint();
			return redirect()->intended();
		}else{
			return redirect('/login')->with(['error'=>'登录失败！']);
		}
	}
	//QQ登录
	private function loginByQQ(){
		$user=Oauth::service('QQ')->user();
		$check=Validator::make([
				'QQopenid'=>$user['openid']
			],
			[
				'QQopenid'=>'required|exists:members,QQopenid'
			]
		);
		if($check->passes()){
			$member=Members::where(['QQopenid'=>$user['openid']])->first();
		}else{
			$member=array(
					'QQopenid'=>$user['openid'],
					'nickname'=>$user['nickname'],
					'actived'=>1
			);
			$member=Members::create($member);
		}
		return $member;
	}
	private function loginByWXPC(){
		$user=Oauth::service('WXPC')->user();
		$check=Validator::make([
				'WXunionid'=>$user['unionid']
			],
			[
				'WXunionid'=>'required|exists:members,WXunionid'
			]
		);
		if($check->passes()){
			$member=Members::where(['WXunionid'=>$user['unionid']])->first();
		}else{
			$member=array(
					'WXunionid'=>$user['unionid'],
					'nickname'=>$user['nickname'],
					'actived'=>1,
					'avatar'=>$user['headimgurl']
			);
			$member=Members::create($member);
		}
		return $member;
	}
	private function loginByWXWAP(){
		$user=Oauth::service('WXWAP')->user();
		$check=Validator::make([
				'WXunionid'=>$user['unionid']
		],
				[
						'WXunionid'=>'required|exists:members,WXunionid'
				]
				);
		if($check->passes()){
			$member=Members::where(['WXunionid'=>$user['unionid']])->first();
		}else{
			$member=array(
					'WXunionid'=>$user['unionid'],
					'nickname'=>$user['nickname'],
					'actived'=>1,
					'avatar'=>$user['headimgurl']
			);
			$member=Members::create($member);
		}
		return $member;
	}
	/*登出*/
	public function logout(Request $request){
		Auth::guard('member')->logout();
		return redirect('/');
	}
	/*登陆获得积分*/
	public function givePoint(){
		$students=Students::where(['parent_id'=>auth('member')->getId(),'del'=>0])->get();
		foreach($students as $s){
			PointController::increaceByRule([
					'rule'=>'login_every_day',
					'student_id'=>$s->id
			]);
		}
	}
}
