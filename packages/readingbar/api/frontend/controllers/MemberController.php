<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use Readingbar\Api\Frontend\Models\Members;
use Readingbar\Api\Functions\AvatarFunction;
use Readingbar\Api\Frontend\Models\Messages;
class MemberController extends FrontController
{
	private $member=null;
	public function __construct(){
		$this->member=auth('member')->member();
	}
	/*获取用户基础信息*/
	public function baseinfo(){
		if($this->member){
			$member=$this->member->toArray();
			/*剔除敏感信息*/
			$cs=array('QQopenid','answer','remember_token','password');
			foreach ($cs as $v){
				if(isset($member[$v])){
					unset($member[$v]);
				}
			}
			$this->json=array('status'=>true,'success'=>'成功获取用户信息！','data'=>$member);
		}else{
			$this->json=array('status'=>false,'error'=>'获取用户信息失败！');
		}
		$this->echoJson();
	}
	/*修改基础信息*/
	public function modifyBaseinfo(Request $request){
		$input=array(
			'nickname'=>$request->input('nickname'),
			'address'=>$request->input('address')
		);
		$rules=array(
			'nickname'=>'required|unique:members,nickname,'.$this->member->id.',id',
			'address'=>'required'
		);
		$attributes=array(
			'nickname'=>trans('members.column_nickname'),
			'address'=>trans('members.column_address')
		);
		$check=Validator::make($input,$rules,array(),$attributes);
		if($check->passes()){
			Members::where(['id'=>$this->member->id])->update($input);
			auth('member')->reflush();
			$this->json=array('status'=>true,'success'=>'信息修改成功！');
		}else{
			$this->json=array('status'=>false,'error'=>$check->messages()->first(),'inputerrors'=>$check->messages()->toArray());
		}
		$this->echoJson();
	}
	/*修改邮箱信息*/
	public function modifyEmail(Request $request){
		$emailcode=session('emailcode');
		if($emailcode){
			$input=array(
					'email'=>$request->input('email'),
					'verification_code_expire'=>$emailcode['expire'],
					'code'=>$request->input('code')
			);
			$rules=array(
					'email'=>'required|unique:members,email,'.$this->member->id.',id',
					'code'=>'required',
					'verification_code_expire'=>'required|numeric|min:'.time()
			);
			$attributes=array(
					'email'=>trans('members.column_email'),
					'code'=>trans('members.column_email_code')
			);
			$check=Validator::make($input,$rules,array(),$attributes);
			if($check->passes()){
				if($emailcode['email']==$request->input('email') && $emailcode['code']==$request->input('code')){
					$oldemail=Members::where('id','=',$this->member->id)->first()->email;
					Members::where(['id'=>$this->member->id])->update(['email'=>$request->input('email')]);
					auth('member')->reflush();
					//修改已有消息的接收方和发送方
					if($oldemail){
						Messages::where(['sendfrom'=>$oldemail])->update(['sendfrom'=>$request->input('email')]);
						Messages::where(['sendto'=>$oldemail])->update(['sendto'=>$request->input('email')]);
					}
					$this->json=array('status'=>true,'success'=>'邮箱修改成功！');
					session()->forget('emailcode');
				}else{
					$this->json=array('status'=>false,'error'=>'验证码验证失败！');
				}
			}else{
				if($check->errors()->has('verification_code_expire')){
					$this->json=array('status'=>false,'error'=>$check->errors()->first('verification_code_expire'),'inputerrors'=>$check->messages()->toArray());
				}else if($check->errors()->has('email')){
					$this->json=array('status'=>false,'error'=>'邮箱已存在！','inputerrors'=>$check->messages()->toArray());
				}else{
					$this->json=array('status'=>false,'error'=>'请输入验证码！','inputerrors'=>$check->messages()->toArray());
				}
			}
		}else{
			$this->json=array('status'=>false,'error'=>'请发送验证信息！');
		}
		$this->echoJson();
	}
	/*修改手机信息*/
	public function modifyMobile(Request $request){
		$cellphonecode=session('cellphonecode');
		if($cellphonecode){
			$input=array(
					'cellphone'=>$request->input('cellphone'),
					'verification_code_expire'=>$cellphonecode['expire'],
					'code'=>$request->input('code')
			);
			$rules=array(
					'cellphone'=>'required|unique:members,cellphone,'.$this->member->id.',id',
					'code'=>'required',
					'verification_code_expire'=>'required|numeric|min:'.time()
			);
			$attributes=array(
					'cellphone'=>trans('members.column_cellphone'),
					'code'=>trans('members.column_cellphone_code')
			);
			$check=Validator::make($input,$rules,array(),$attributes);
			if($check->passes()){
				if($cellphonecode['cellphone']==$request->input('cellphone') && $cellphonecode['code']==$request->input('code')){
					$oldcellphone=Members::where('id','=',$this->member->id)->first()->cellphone;
					Members::where(['id'=>$this->member->id])->update(['cellphone'=>$request->input('cellphone')]);
					auth('member')->reflush();
					//修改已有消息的接收方和发送方
					if($oldcellphone){
						Messages::where(['sendfrom'=>$oldcellphone])->update(['sendfrom'=>$request->input('cellphone')]);
						Messages::where(['sendto'=>$oldcellphone])->update(['sendto'=>$request->input('cellphone')]);
					}
					$this->json=array('status'=>true,'success'=>'手机修改成功！');
					session()->forget('cellphonecode');
				}else{
					$this->json=array('status'=>false,'error'=>'验证码验证失败！');
				}
			}else{
				if($check->errors()->has('verification_code_expire')){
					$this->json=array('status'=>false,'error'=>$check->errors()->first('verification_code_expire'),'inputerrors'=>$check->messages()->toArray());
				}else if($check->errors()->has('cellphone')){
					$this->json=array('status'=>false,'error'=>'手机号码已存在！','inputerrors'=>$check->messages()->toArray());
				}else{
					$this->json=array('status'=>false,'error'=>'请输入验证码！','inputerrors'=>$check->messages()->toArray());
				}
			}
		}else{
			$this->json=array('status'=>false,'error'=>'请发送验证信息！');
		}
		$this->echoJson();
	}
	/*安全问题修改*/
	public function modifyAq(Request $request){
		$input=array(
				'question'=>$request->input('question'),
				'answer'=>$request->input('answer')
		);
		$rules=array(
				'question'=>'required',
				'answer'=>'required',
		);
		$attributes=array(
				'question'=>trans('members.column_question'),
				'answer'=>trans('members.column_answer')
		);
		$check=Validator::make($input,$rules,array(),$attributes);
		if($check->passes()){
			Members::where(['id'=>$this->member->id])->update($input);
			auth('member')->reflush();
			$this->json=array('status'=>true,'success'=>'安全问题修改成功！');
		}else{
			$this->json=array('status'=>false,'error'=>'安全问题修改失败！','inputerrors'=>$check->messages()->toArray());
		}
		$this->echoJson();
	}
	/*密码修改*/
	public function modifyPassword(Request $request){
		$input=array(
				'password'=>$request->input('password'),
				'password_confirmation'=>$request->input('password_confirmation')
		);
		$rules=array(
				'password'=>'required|min:8|regex:/^(?=.*[0-9].*)(?=.*[a-zA-Z].*).{8,20}$/|confirmed',
		);
		$attributes=array(
				'password'=>trans('members.column_password'),
		);
		$check=Validator::make($input,$rules,array(),$attributes);
		if($check->passes()){
			Members::where(['id'=>$this->member->id])->update(['password'=>bcrypt($request->input('password'))]);
			auth('member')->reflush();
			$this->json=array('status'=>true,'success'=>'密码修改成功！');
		}else{
			$this->json=array('status'=>false,'error'=>$check->errors()->first('password'),'inputerrors'=>$check->messages()->toArray());
		}
		$this->echoJson();
	}
	/*头像修改*/
	public function modifyAvatar(Request $request){
		$avatar=AvatarFunction::setAvatar($request->file('member_avatar'),'avatar_member_'.$this->member->id,$request->input('member_avatar_width'), $request->input('member_avatar_height'), $request->input('member_avatar_x'),$request->input('member_avatar_y'));
		Members::where(['id'=>$this->member->id])->update(['avatar'=>$avatar]);
		auth('member')->reflush();
		$this->json=array('status'=>true,'success'=>'头像修改成功！','avatar'=>$avatar);
		$this->echoJson();
	}
}
