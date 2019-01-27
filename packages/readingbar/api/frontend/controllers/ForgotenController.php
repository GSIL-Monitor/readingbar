<?php

namespace Readingbar\Api\Frontend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use Readingbar\Api\Functions\MemberFunction;
use Readingbar\Api\Frontend\Models\Members;

class ForgotenController extends FrontController
{
	/*找回密码*/
	public function forgoten(Request $request){
		$column=MemberFunction::checkUsernameType($request->input('username'));
		$forgotencode=session('forgotencode');
		$inputs=array(
			'username'=>$request->input('username'),
			'username_format'=>$column,
			'password'=>$request->input('password'),
			'password_confirmation'=>$request->input('password_confirmation'),
			'verification_message'=>$forgotencode?$forgotencode['username'].$forgotencode['code']:null,
			'verification_code'=>$request->input('code')?$request->input('username').$request->input('code'):null,
			'verification_code_expire'=>$forgotencode['expire']
		);
		$rules=array(
			'username_format'=>'required|in:email,cellphone',
			'password'=>'required|min:8|regex:/^(?=.*[0-9].*)(?=.*[a-zA-Z].*).{8,20}$/|confirmed',
			'verification_message'=>'required',
			'verification_code'=>'required|same:verification_message',
			'verification_code_expire'=>'required|numeric|min:'.time()
		);
		if($column!='undefined'){
			$rules['username']='required|exists:members,'.$column.',actived,1';
		}
		$check=Validator::make($inputs,$rules);
		
		if($check->passes()){
			session()->forget('forgotencode');
			Members::where([$column=>$request->input('username')])->update(['password'=>bcrypt($request->input('password'))]);
			return redirect('/login')->with(['success'=>'密码已修改请尝试登录！']);
		}else{
			return redirect('/forgoten')->withErrors($check->errors())->withInput();
		}
	}
}
